<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admin Dashboard</h1>
</div>

<!-- Stat Cards -->
<div class="row g-4">
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title"><?= $stats['total_students'] ?></h3>
                        <p class="card-text">Total Students</p>
                    </div>
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title"><?= $stats['active_courses'] ?></h3>
                        <p class="card-text">Active Courses</p>
                    </div>
                    <i class="bi bi-book-half fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title"><?= $stats['total_enrollments'] ?></h3>
                        <p class="card-text">Enrollments</p>
                    </div>
                    <i class="bi bi-person-check-fill fs-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-neumorphic h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title"><?= $stats['pending_notes'] ?></h3>
                        <p class="card-text">Notes for Review</p>
                    </div>
                    <i class="bi bi-journal-arrow-down fs-1 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                User Signups Overview
            </div>
            <div class="card-body">
                <canvas id="userSignupsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('userSignupsChart').getContext('2d');
    const chartData = JSON.parse('<?= $chartData ?>');

    // Set chart styles based on theme
    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    const fontColor = isDarkMode ? '#e0e0e0' : '#333';

    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: fontColor }
                },
                x: {
                    grid: { color: gridColor },
                    ticks: { color: fontColor }
                }
            },
            plugins: {
                legend: {
                    labels: { color: fontColor }
                }
            }
        }
    });
});
</script>
