<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Course;
use App\Models\Note;

class NoteController extends Controller
{
    private Note $noteModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->noteModel = new Note();
    }

    // Show all notes for the current user
    public function index(): void
    {
        $userId = $_SESSION['user_id'];
        $notes = $this->noteModel->findByUser($userId);
        $this->render('notes/index', ['title' => 'My Notes', 'notes' => $notes]);
    }

    // Show the form to upload a new note
    public function create(): void
    {
        // We need a list of courses for the dropdown
        $courseModel = new Course();
        $courses = $courseModel->findAll();
        $this->render('notes/upload', ['title' => 'Upload Note', 'courses' => $courses]);
    }

    // Handle the note upload
    public function store(): void
    {
        $body = $this->request->getBody();
        $file = $this->request->file('note_file');
        $userId = $_SESSION['user_id'];

        // --- Validation ---
        // Basic validation for title and course
        if (empty($body['title']) || empty($body['course_id'])) {
            // Handle error
            $this->response->redirect('/my-notes/upload?error=validation');
            return;
        }

        // File upload validation
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $this->response->redirect('/my-notes/upload?error=file_upload');
            return;
        }

        // Size validation (e.g., 5MB max)
        if ($file['size'] > 5 * 1024 * 1024) {
            $this->response->redirect('/my-notes/upload?error=file_size');
            return;
        }

        // Type validation (allow only PDFs)
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if ($mimeType !== 'application/pdf') {
            $this->response->redirect('/my-notes/upload?error=file_type');
            return;
        }

        // --- File Processing ---
        $uploadDir = BASE_PATH . '/storage/uploads/notes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // File moved successfully, save to DB
            $this->noteModel->create([
                'user_id' => $userId,
                'course_id' => $body['course_id'],
                'title' => $body['title'],
                'file_path' => '/storage/uploads/notes/' . $fileName // Store web-accessible path
            ]);
            $this->response->redirect('/my-notes');
        } else {
            $this->response->redirect('/my-notes/upload?error=file_move');
        }
    }
}
