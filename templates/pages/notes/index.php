<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Notes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/my-notes/upload" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-plus-circle"></i>
            Upload New Note
        </a>
    </div>
</div>

<p>Here you can see the status of all the notes you have uploaded.</p>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Course</th>
                        <th scope="col">Uploaded At</th>
                        <th scope="col">Status</th>
                        <th scope="col">Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($notes)): ?>
                        <tr>
                            <td colspan="5" class="text-center">You haven't uploaded any notes yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($notes as $note): ?>
                        <tr>
                            <td><?= htmlspecialchars($note['title']) ?></td>
                            <td><?= htmlspecialchars($note['course_title']) ?></td>
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
                                <?php if ($note['status'] === 'approved'): ?>
                                    <a href="<?= htmlspecialchars($note['file_path']) ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                                <?php else: ?>
                                    -
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
