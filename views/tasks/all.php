<div class="container my-4">
    <h2>Усі завдання</h2>

    <form method="get" action="/tasks/all" class="row mb-4">
        <div class="col-md-3">
            <input type="number" name="cost_min" class="form-control" placeholder="Мін. вартість"
                   value="<?= htmlspecialchars($filters['cost_min'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <input type="number" name="cost_max" class="form-control" placeholder="Макс. вартість"
                   value="<?= htmlspecialchars($filters['cost_max'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control"
                   value="<?= htmlspecialchars($filters['date'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-warning w-100">Фільтрувати</button>
        </div>
    </form>

    <?php if (!empty($tasks)): ?>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <h5><?= htmlspecialchars($task['short_text']) ?></h5>
                        <p><?= htmlspecialchars($task['description']) ?></p>
                        <p><strong><?= $task['cost'] ?> грн</strong></p>
                        <p><small><?= $task['date'] ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Завдань не знайдено за заданими критеріями.</p>
    <?php endif; ?>
</div>
