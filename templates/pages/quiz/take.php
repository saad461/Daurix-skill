<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h1 class="h2"><?= htmlspecialchars($title) ?></h1>
                <p class="lead">Answer the questions below to the best of your ability.</p>
            </div>

            <div class="card card-neumorphic">
                <div class="card-body p-4 p-md-5">
                    <form action="/courses/<?= $courseId ?>/quiz" method="POST">
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="mb-4">
                                <p class="fw-bold"><?= ($index + 1) . '. ' . htmlspecialchars($question['question_text']) ?></p>
                                <div class="ms-3">
                                    <?php foreach ($question['options'] as $option): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" id="answer-<?= $option['id'] ?>" value="<?= $option['id'] ?>" required>
                                            <label class="form-check-label" for="answer-<?= $option['id'] ?>">
                                                <?= htmlspecialchars($option['answer_text']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php if ($index < count($questions) - 1): ?>
                                <hr class="my-4">
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <div class="d-grid mt-5">
                             <button type="submit" class="btn btn-primary btn-lg">Submit Quiz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
