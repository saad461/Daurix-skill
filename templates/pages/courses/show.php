<div class="container-fluid">
    <!-- Course Header -->
    <div class="row">
        <div class="col-12">
            <div class="card card-body p-5 rounded-3 mb-4" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); color: white;">
                <h1 class="display-4 animate__animated animate__fadeInDown"><?= htmlspecialchars($course['title']) ?></h1>
                <p class="lead animate__animated animate__fadeInUp"><?= htmlspecialchars($course['description']) ?></p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="#" class="btn btn-light btn-lg mt-3 animate__animated animate__pulse" style="width: fit-content;">Start Course</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-light btn-lg mt-3 animate__animated animate__pulse" style="width: fit-content;">Login to Enroll</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="row">
        <div class="col-lg-8">
            <h2 class="h3 mb-3">Course Content</h2>
            <div class="accordion" id="courseAccordion">
                <?php if (empty($course['modules'])): ?>
                    <p>No modules available for this course yet.</p>
                <?php else: ?>
                    <?php foreach ($course['modules'] as $module): ?>
                        <div class="accordion-item card-neumorphic mb-3">
                            <h2 class="accordion-header" id="heading-<?= $module['id'] ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $module['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $module['id'] ?>">
                                    <i class="bi bi-collection-play-fill me-2"></i>
                                    <strong><?= htmlspecialchars($module['title']) ?></strong>
                                </button>
                            </h2>
                            <div id="collapse-<?= $module['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $module['id'] ?>" data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        <?php if (empty($module['lessons'])): ?>
                                            <li class="list-group-item">No lessons in this module yet.</li>
                                        <?php else: ?>
                                            <?php foreach ($module['lessons'] as $lesson): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="/lessons/<?= $lesson['id'] ?>" class="text-decoration-none">
                                                        <i class="bi bi-play-circle me-2"></i>
                                                        <?= htmlspecialchars($lesson['title']) ?>
                                                    </a>
                                                    <span class="badge bg-primary rounded-pill">15 min</span>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="card-title">Course Details</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-bar-chart-steps me-2"></i><strong>Modules:</strong> <?= count($course['modules']) ?></li>
                        <li><i class="bi bi-clock me-2"></i><strong>Estimated Time:</strong> 12 hours</li>
                        <li><i class="bi bi-reception-4 me-2"></i><strong>Skill Level:</strong> Beginner</li>
                        <li><i class="bi bi-patch-check-fill me-2"></i><strong>Certificate:</strong> Yes</li>
                    </ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <hr>
                    <div class="d-grid">
                        <a href="/courses/<?= $course['id'] ?>/quiz" class="btn btn-success"><i class="bi bi-check2-square me-2"></i>Take Final Quiz</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Placeholder for 404 error page -->
<?php
// This check is needed because the controller can render this.
// I will create this file now.
if (!file_exists(BASE_PATH . '/templates/pages/errors/404.php')) {
    if (!is_dir(BASE_PATH . '/templates/pages/errors')) {
        mkdir(BASE_PATH . '/templates/pages/errors', 0777, true);
    }
    file_put_contents(BASE_PATH . '/templates/pages/errors/404.php', '<h1>404 - Page Not Found</h1><p>Sorry, the page you are looking for could not be found.</p><a href="/">Go Home</a>');
}
?>
