<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Ai extends Model
{
    /**
     * Finds relevant course summaries based on keywords in the user's message.
     * This is a very simple RAG implementation.
     *
     * @param string $message
     * @param int $limit
     * @return array
     */
    public function findRelevantSummaries(string $message, int $limit = 3): array
    {
        // A real implementation would use a more sophisticated search (e.g., full-text, embeddings)
        // For this demo, we'll do a simple LIKE search.
        $words = array_filter(explode(' ', $message), fn($word) => strlen($word) > 3);
        if (empty($words)) {
            return [];
        }

        $sql = "SELECT summary FROM course_summaries WHERE ";
        $conditions = [];
        $params = [];
        foreach ($words as $i => $word) {
            $key = ":word" . $i;
            $conditions[] = "summary LIKE " . $key;
            $params[$key] = '%' . $word . '%';
        }
        $sql .= implode(' OR ', $conditions) . " LIMIT " . $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Saves a message to the conversation history.
     *
     * @param int $userId
     * @param string $sessionId
     * @param string $message
     * @param string $sender 'user' or 'ai'
     * @return bool
     */
    public function saveMessage(int $userId, string $sessionId, string $message, string $sender): bool
    {
        $sql = "INSERT INTO ai_conversations (user_id, session_id, message, sender) VALUES (:user_id, :session_id, :message, :sender)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'message' => $message,
            'sender' => $sender,
        ]);
    }

    /**
     * Get the last N messages from a conversation session.
     *
     * @param string $sessionId
     * @param int $limit
     * @return array
     */
    public function getConversationHistory(string $sessionId, int $limit = 10): array
    {
        $sql = "SELECT sender, message FROM ai_conversations WHERE session_id = :session_id ORDER BY timestamp DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':session_id', $sessionId, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        // Return in chronological order
        return array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
