<?php
$workers = $workers ?? [];
$Title = 'Find All ';
?>

<div class="row m-3">
    <?php foreach ($workers as $worker): ?>
        <div class="col-md-3">
            <div class="card border rounded-3 mb-2" style="height: 500px">
                <div class="p-4">
                    <h5><?= htmlspecialchars($worker->user->name) ?> <?= htmlspecialchars($worker->user->surname) ?></h5>
                    <p class="text-muted"><?= htmlspecialchars($worker->user->city) ?></p>
                    <div class="mb-3">
                        <strong>Категорії:</strong>
                        <div class="d-flex flex-wrap">
                            <?php
                            $categories = is_array($worker->categories)
                                ? $worker->categories
                                : explode(',', $worker->categories ?? '');
                            foreach ($categories as $cat): ?>
                                <span class="badge bg-secondary m-1"><?= htmlspecialchars(trim($cat)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <p><strong><?= htmlspecialchars($worker->pay_per_hour) ?> грн/год</strong></p>
                    <a href="/users/see/<?php echo $worker->id_user?>" class="btn btn-warning w-100">Переглянути акаунт</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
