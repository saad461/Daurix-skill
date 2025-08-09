<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">

            <div id="success-animation" style="width: 200px; height: 200px; margin: auto;"></div>

            <h1 class="display-4">Quiz Complete!</h1>
            <p class="lead">Congratulations on completing the quiz.</p>

            <div class="card card-neumorphic mt-4">
                <div class="card-body">
                    <h2 class="h3">Your Score:</h2>
                    <p class="display-3 fw-bold text-primary"><?= htmlspecialchars(number_format($submission['score'], 2)) ?>%</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="/dashboard" class="btn btn-primary btn-lg">Back to Dashboard</a>
                <a href="/courses" class="btn btn-secondary btn-lg">Browse More Courses</a>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lottie.loadAnimation({
            container: document.getElementById('success-animation'),
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: '/assets/lottie/success.json'
        });
    });
</script>

<!-- Placeholder for 403 error page -->
<?php
if (!file_exists(BASE_PATH . '/templates/pages/errors/403.php')) {
    if (!is_dir(BASE_PATH . '/templates/pages/errors')) {
        mkdir(BASE_PATH . '/templates/pages/errors', 0777, true);
    }
    file_put_contents(BASE_PATH . '/templates/pages/errors/403.php', '<h1>403 - Access Denied</h1><p>Sorry, you do not have permission to access this page.</p><a href="/">Go Home</a>');
}
?>
