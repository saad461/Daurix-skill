<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'DaurixSkills' ?> - DaurixSkills</title>
    <meta name="description" content="<?= $description ?? 'Elevate your skills with our online courses.' ?>">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/theme.css">

</head>
<body>
    <?php $isLoggedIn = isset($_SESSION['user_id']); ?>

    <div class="<?= $isLoggedIn ? 'd-flex' : '' ?>" id="wrapper">
        <?php if ($isLoggedIn): ?>
            <!-- Sidebar for logged-in users -->
            <?php include_once BASE_PATH . '/templates/layouts/partials/_sidebar.php'; ?>
        <?php endif; ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation -->
            <?php include_once BASE_PATH . '/templates/layouts/partials/_header.php'; ?>

            <!-- Main Content -->
            <main class="container-fluid p-4" id="main-content">
                {{content}}
            </main>

            <!-- Footer -->
            <?php include_once BASE_PATH . '/templates/layouts/partials/_footer.php'; ?>
        </div>
    </div>

    <!-- Zahra AI Floating Button (conditionally shown by JS if user is logged in) -->
    <?php if ($isLoggedIn): ?>
        <div id="zahra-chat-widget-container"></div>
    <?php endif; ?>


    <!-- Core JS Libraries -->
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <!-- Lottie for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js (for admin dashboards) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/zahra-ai-widget.js"></script>

    <!-- Per-page scripts can be injected here -->
    <?php if (!empty($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
