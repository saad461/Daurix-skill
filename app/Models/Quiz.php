<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Quiz extends Model
{
    /**
     * Find a quiz by its associated course ID.
     *
     * @param int $courseId
     * @return array|false
     */
    public function findByCourseId(int $courseId): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE course_id = :course_id LIMIT 1");
        $stmt->execute([':course_id' => $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all questions for a quiz, including their answer options.
     *
     * @param int $quizId
     * @return array
     */
    public function getQuestionsWithOptions(int $quizId): array
    {
        $qStmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
        $qStmt->execute([':quiz_id' => $quizId]);
        $questions = $qStmt->fetchAll(PDO::FETCH_ASSOC);

        $aStmt = $this->db->prepare("SELECT id, answer_text FROM answers WHERE question_id = :question_id");

        foreach ($questions as $key => $question) {
            $aStmt->execute([':question_id' => $question['id']]);
            $questions[$key]['options'] = $aStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $questions;
    }

    /**
     * Calculate the score for a submission.
     *
     * @param int $quizId
     * @param array $userAnswers Associative array of [question_id => answer_id]
     * @return float The score percentage.
     */
    public function calculateScore(int $quizId, array $userAnswers): float
    {
        $stmt = $this->db->prepare(
            "SELECT q.id as question_id, a.id as correct_answer_id
             FROM questions q
             JOIN answers a ON q.id = a.question_id
             WHERE q.quiz_id = :quiz_id AND a.is_correct = 1"
        );
        $stmt->execute([':quiz_id' => $quizId]);
        $correctAnswers = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $correctCount = 0;
        $totalQuestions = count($correctAnswers);

        if ($totalQuestions === 0) {
            return 0.0;
        }

        foreach ($userAnswers as $questionId => $answerId) {
            if (isset($correctAnswers[$questionId]) && (int)$correctAnswers[$questionId] === (int)$answerId) {
                $correctCount++;
            }
        }

        return ($correctCount / $totalQuestions) * 100;
    }

    /**
     * Save a user's quiz submission.
     *
     * @param int $quizId
     * @param int $userId
     * @param float $score
     * @return int The ID of the new submission.
     */
    public function saveSubmission(int $quizId, int $userId, float $score): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO quiz_submissions (quiz_id, user_id, score) VALUES (:quiz_id, :user_id, :score)"
        );
        $stmt->execute([
            ':quiz_id' => $quizId,
            ':user_id' => $userId,
            ':score' => $score,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Find a submission by its ID.
     *
     * @param int $submissionId
     * @return array|false
     */
    public function findSubmissionById(int $submissionId): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM quiz_submissions WHERE id = :id");
        $stmt->execute([':id' => $submissionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
