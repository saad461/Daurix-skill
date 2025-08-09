<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Student Notes</h1>
</div>

<p>Review student-uploaded notes. Approve them to make them visible to the student, or reject them.</p>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Course</th>
                        <th scope="col">User</th>
                        <th scope="col">Uploaded At</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($notes)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No notes have been submitted yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($notes as $note): ?>
                        <tr>
                            <td><?= htmlspecialchars($note['title']) ?></td>
                            <td><?= htmlspecialchars($note['course_title']) ?></td>
                            <td><?= htmlspecialchars($note['user_name']) ?></td>
                            <td><?= date('M d, Y', strtotime($note['uploaded_at'])) ?></td>
                            <td>
                                <?php
                                    $statusClass = 'text-bg-secondary';
                                    if ($note['status'] === 'approved') $statusClass = 'text-bg-success';
                                    if ($note['status'] === 'rejected') $statusClass = 'text-bg-danger';
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= ucfirst($note['status']) ?></span>
                            </td>
                            <td>
                                <a href="<?= htmlspecialchars($note['file_path']) ?>" target="_blank" class="btn btn-info btn-sm">Preview</a>
                                <?php if ($note['status'] === 'pending'): ?>
                                    <form action="/admin/notes/<?= $note['id'] ?>/approve" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="/admin/notes/<?= $note['id'] ?>/reject" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
