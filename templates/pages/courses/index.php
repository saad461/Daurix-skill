<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= htmlspecialchars($title) ?></h1>
</div>

<p class="lead">Browse our catalog of courses to find your next learning adventure.</p>

<div class="row g-4 mt-3">
    <?php if (empty($courses)): ?>
        <div class="col">
            <p>No courses are available at the moment. Please check back later.</p>
        </div>
    <?php else: ?>
        <?php foreach ($courses as $course): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card card-neumorphic h-100">
                    <?php if ($course['featured_image']): ?>
                        <img src="<?= htmlspecialchars($course['featured_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                    <?php else: ?>
                         <img src="https://via.placeholder.com/400x250.png/E9ECEF/6C757D?text=DaurixSkills" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                        <a href="/courses/<?= htmlspecialchars($course['slug']) ?>" class="btn btn-primary mt-auto animate__animated animate__pulse">View Course</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
