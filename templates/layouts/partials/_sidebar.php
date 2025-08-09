<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-light">
        <a href="/" class="text-decoration-none text-dark">
            <img src="/assets/images/logo.svg" alt="DaurixSkills Logo" height="30" class="me-2">
            DaurixSkills
        </a>
    </div>
    <div class="list-group list-group-flush">
        <span class="list-group-item list-group-item-action list-group-item-light p-3 fw-bold">Student Menu</span>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/courses"><i class="bi bi-book me-2"></i>Courses</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/my-notes"><i class="bi bi-journal-text me-2"></i>My Notes</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/messages"><i class="bi bi-chat-dots me-2"></i>Messages</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/analytics"><i class="bi bi-graph-up me-2"></i>My Analytics</a>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <span class="list-group-item list-group-item-action list-group-item-light p-3 fw-bold mt-3">Admin Menu</span>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/dashboard"><i class="bi bi-shield-lock me-2"></i>Admin Dashboard</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/users"><i class="bi bi-people me-2"></i>Manage Users</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/courses"><i class="bi bi-pencil-square me-2"></i>Manage Courses</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/quizzes"><i class="bi bi-patch-question me-2"></i>Manage Quizzes</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/notes"><i class="bi bi-check2-square me-2"></i>Approve Notes</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/admin/settings"><i class="bi bi-gear me-2"></i>Settings</a>
        <?php endif; ?>
    </div>
</div>
