<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Course</h1>
</div>

<form action="/admin/courses" method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Course Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Course Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>
    <!-- Add fields for featured_image etc. if needed -->
    <button type="submit" class="btn btn-primary">Save Course</button>
    <a href="/admin/courses" class="btn btn-secondary">Cancel</a>
</form>
