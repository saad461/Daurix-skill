<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Upload a New Note</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                            switch ($_GET['error']) {
                                case 'validation': echo 'Please fill in all fields.'; break;
                                case 'file_upload': echo 'There was an error uploading your file.'; break;
                                case 'file_size': echo 'The file is too large. Maximum size is 5MB.'; break;
                                case 'file_type': echo 'Invalid file type. Only PDF files are allowed.'; break;
                                case 'file_move': echo 'Could not save the uploaded file. Please try again.'; break;
                                default: echo 'An unknown error occurred.';
                            }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="/my-notes" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Note Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Select Course</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <option value="" selected disabled>Choose a course...</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note_file" class="form-label">Note File (PDF only, max 5MB)</label>
                        <input class="form-control" type="file" id="note_file" name="note_file" accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Note</button>
                    <a href="/my-notes" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
