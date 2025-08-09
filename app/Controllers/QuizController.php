<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\User;

class QuizController extends Controller
{
    private Quiz $quizModel;
    private User $userModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->quizModel = new Quiz();
        $this->userModel = new User();
    }

    /**
     * Show the quiz for a given course.
     *
     * @param int $courseId
     */
    public function show(int $courseId): void
    {
        $quiz = $this->quizModel->findByCourseId($courseId);

        if (!$quiz) {
            // Handle no quiz found for this course
            $this->render('errors/404', ['title' => 'Quiz Not Found']);
            return;
        }

        $questions = $this->quizModel->getQuestionsWithOptions($quiz['id']);

        $this->render('quiz/take', [
            'title' => $quiz['title'],
            'quiz' => $quiz,
            'questions' => $questions,
            'courseId' => $courseId,
        ]);
    }

    /**
     * Process the quiz submission.
     *
     * @param int $courseId
     */
    public function submit(int $courseId): void
    {
        $body = $this->request->getBody();
        $quiz = $this->quizModel->findByCourseId($courseId);
        $userId = $_SESSION['user_id'];
        $answers = $body['answers'] ?? [];

        if (!$quiz || !$userId) {
            // Should not happen in normal flow
            $this->response->redirect('/');
            return;
        }

        $score = $this->quizModel->calculateScore($quiz['id'], $answers);
        $submissionId = $this->quizModel->saveSubmission($quiz['id'], $userId, $score);

        // Award points if the user passed the quiz (e.g., score >= 80)
        if ($score >= 80) {
            $pointsToAward = 50;
            $this->userModel->addPoints(
                $userId,
                $pointsToAward,
                "Passed quiz: " . $quiz['title'],
                $submissionId,
                'quiz_submission'
            );
        }

        $this->response->redirect("/quiz/submission/{$submissionId}");
    }

    /**
     * Show the results of a specific submission.
     *
     * @param int $submissionId
     */
    public function showResult(int $submissionId): void
    {
        $submission = $this->quizModel->findSubmissionById($submissionId);

        // Basic authorization check: does this submission belong to the current user?
        if (!$submission || $submission['user_id'] != $_SESSION['user_id']) {
            $this->response->setStatusCode(403);
            $this->render('errors/403', ['title' => 'Access Denied']);
            return;
        }

        $this->render('quiz/result', [
            'title' => 'Quiz Results',
            'submission' => $submission
        ]);
    }
}
