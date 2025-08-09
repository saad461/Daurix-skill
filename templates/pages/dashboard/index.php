<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome back, <?= htmlspecialchars($userName ?? 'Student') ?>!</h1>
</div>

<p class="lead">Here's a summary of your activity on the platform. Keep up the great work!</p>

<div class="row g-4 mt-3">
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body text-center">
                <i class="bi bi-journal-bookmark-fill fs-1 text-primary"></i>
                <h3 class="card-title mt-3"><?= $stats['enrolled_courses'] ?></h3>
                <p class="card-text">Courses Enrolled</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                <h3 class="card-title mt-3"><?= $stats['completed_lessons'] ?></h3>
                <p class="card-text">Lessons Completed</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body text-center">
                <i class="bi bi-patch-question-fill fs-1 text-warning"></i>
                <h3 class="card-title mt-3"><?= $stats['quizzes_taken'] ?></h3>
                <p class="card-text">Quizzes Taken</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body text-center">
                <i class="bi bi-award-fill fs-1 text-info"></i>
                <h3 class="card-title mt-3"><?= $stats['certificates_earned'] ?></h3>
                <p class="card-text">Certificates Earned</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h2 class="h3">Continue Learning</h2>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Web Development Basics</h5>
            <p class="card-text">You are on Module 2: JavaScript Fundamentals.</p>
            <div class="progress mb-3">
                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
            </div>
            <a href="/courses/web-development-basics" class="btn btn-primary animate__animated animate__pulse animate__infinite">Resume Course</a>
        </div>
    </div>
</div>
