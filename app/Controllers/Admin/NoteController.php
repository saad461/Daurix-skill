<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Note;

class NoteController extends Controller
{
    private Note $noteModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->noteModel = new Note();
    }

    // List all notes for admin review
    public function index(): void
    {
        $notes = $this->noteModel->findAllForAdmin();
        $this->render('admin/notes/index', ['title' => 'Manage Student Notes', 'notes' => $notes]);
    }

    // Approve a note
    public function approve(int $id): void
    {
        $this->noteModel->updateStatus($id, 'approved');
        $this->response->redirect('/admin/notes');
    }

    // Reject a note
    public function reject(int $id): void
    {
        $this->noteModel->updateStatus($id, 'rejected');
        $this->response->redirect('/admin/notes');
    }
}
