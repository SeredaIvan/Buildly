<?php

use models\User;
use models\Worker;
?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="container my-4">
    <h2>Усі завдання</h2>

    <form method="get" action="/tasks/all" class="row mb-4 gx-2">
        <div class="col-md-2">
            <input
                    type="number"
                    name="cost_min"
                    class="form-control"
                    placeholder="Мін. вартість"
                    value="<?= htmlspecialchars($filters['cost_min'] ?? '') ?>"
            >
        </div>
        <div class="col-md-2">
            <input
                    type="number"
                    name="cost_max"
                    class="form-control"
                    placeholder="Макс. вартість"
                    value="<?= htmlspecialchars($filters['cost_max'] ?? '') ?>"
            >
        </div>
        <div class="col-md-2">
            <input
                    type="date"
                    name="date"
                    class="form-control"
                    value="<?= htmlspecialchars($filters['date'] ?? '') ?>"
            >
        </div>
        <div class="col-md-2">
            <input
                    type="text"
                    name="city"
                    class="form-control"
                    placeholder="Місто"
                    value="<?= htmlspecialchars($filters['city'] ?? '') ?>"
            >
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">Всі категорії</option>
                <?php
                $allCategories = \core\Config::getInstance()->paramsCategories[0] ?? [];
                foreach ($allCategories as $group) {
                    foreach ($group as $item) {
                        $sel = (isset($filters['category']) && $filters['category'] === $item) ? ' selected' : '';
                        echo '<option value="' . htmlspecialchars($item) . '"' . $sel . '>'
                            . htmlspecialchars($item)
                            . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-warning w-100">Фільтрувати</button>
        </div>
    </form>

    <?php if (!empty($tasks)): ?>
        <div class="row g-3">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-4">
                    <div class="card h-100 p-3">
                        <h5><?= htmlspecialchars($task['short_text'] ?? '') ?></h5>
                        <p><?= htmlspecialchars($task['description'] ?? '') ?></p>
                        <p>
                            <strong><?= htmlspecialchars($task['cost'] ?? '') ?> грн</strong>
                            —
                            <?= htmlspecialchars($task['city'] ?? '') ?>,
                            <?= htmlspecialchars($task['category'] ?? '') ?>
                        </p>
                        <p><small><?= htmlspecialchars($task['date'] ?? '') ?></small></p>

                        <?php if (!empty($task['id_worker'])): ?>
                            <p class="text-danger"><small>В роботі</small></p>
                        <?php else: ?>
                            <?php
                            $curUser = User::GetUser();
                            if ($curUser && $curUser->IsWorker()):
                                $worker = Worker::selectByUserId($curUser->id);
                                ?>
                                <form action="/offers/offerjob" method="post" class="mt-2">
                                    <input type="hidden" name="task_id"   value="<?= htmlspecialchars($task['id'] ?? '') ?>">
                                    <input type="hidden" name="worker_id" value="<?= htmlspecialchars($worker->id ?? '') ?>">
                                    <button type="submit" class="btn btn-warning w-100">Запропонувати</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Завдань не знайдено за заданими критеріями.</div>
    <?php endif; ?>
</div>
