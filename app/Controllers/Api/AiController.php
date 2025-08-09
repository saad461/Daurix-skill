<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Models\Ai;

class AiController extends Controller
{
    private Ai $aiModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->aiModel = new Ai();
    }

    public function chat(): void
    {
        $body = $this->request->getBody();
        $userMessage = $body['message'] ?? '';
        $sessionId = $body['session_id'] ?? uniqid('chat_');
        $userId = $_SESSION['user_id']; // Assumes AuthMiddleware has run

        if (empty($userMessage)) {
            $this->response->json(['error' => 'Message is required'], 400);
            return;
        }

        // 1. Save user message
        $this->aiModel->saveMessage($userId, $sessionId, $userMessage, 'user');

        // 2. Get context (RAG + History)
        $summaries = $this->aiModel->findRelevantSummaries($userMessage);
        $history = $this->aiModel->getConversationHistory($sessionId);

        // 3. Call AI Service
        $aiResponseText = $this->callOpenAiApi($userMessage, $summaries, $history);

        if (!$aiResponseText) {
            $this->response->json(['error' => 'Failed to get response from AI service'], 500);
            return;
        }

        // 4. Save AI response
        $this->aiModel->saveMessage($userId, $sessionId, $aiResponseText, 'ai');

        // 5. Return response
        $this->response->json([
            'reply' => $aiResponseText,
            'session_id' => $sessionId
        ]);
    }

    private function callOpenAiApi(string $userMessage, array $summaries, array $history): ?string
    {
        $apiKey = $_ENV['OPENAI_API_KEY'];
        $apiBaseUrl = $_ENV['OPENAI_API_BASE_URL'] ?? 'https://api.openai.com/v1';
        $apiUrl = $apiBaseUrl . '/chat/completions';

        $systemPrompt = "You are Zahra, a helpful AI assistant for the DaurixSkills platform. Be concise and friendly. ";
        if (!empty($summaries)) {
            $systemPrompt .= "Here is some context that might be relevant to the user's question: \n\n" . implode("\n", $summaries);
        }

        $messages = [['role' => 'system', 'content' => $systemPrompt]];
        foreach ($history as $msg) {
            $messages[] = ['role' => $msg['sender'], 'content' => $msg['message']];
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];


        $postData = [
            'model' => 'gpt-3.5-turbo', // Or any other compatible model
            'messages' => $messages,
            'max_tokens' => 250,
            'temperature' => 0.7,
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            // In a real app, log the error
            return "Sorry, I'm having trouble connecting to my brain right now.";
        }

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? null;
    }
}
