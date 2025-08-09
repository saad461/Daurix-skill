<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User: <?= htmlspecialchars($user['name']) ?></h1>
</div>

<form action="/admin/users/<?= $user['id'] ?>" method="POST">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" disabled>
        <div class="form-text">Password cannot be changed from this form.</div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" class="form-control" id="points" name="points" value="<?= $user['points'] ?>" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update User</button>
    <a href="/admin/users" class="btn btn-secondary">Cancel</a>
</form>
