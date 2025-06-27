<?php
/** @var models\Brigade      $brigade */
/** @var models\User|null     $user */
/** @var bool                 $isJoined */
/** @var models\Worker[]      $members */

$this->Title = "Бригада №" . htmlspecialchars($brigade->id);
?>

<div class="container my-4">
    <h2>Бригада №<?= htmlspecialchars($brigade->id) ?></h2>
    <p><strong>Категорії:</strong> <?= htmlspecialchars($brigade->categories) ?></p>
    <p><strong>Оплата за годину:</strong> <?= htmlspecialchars($brigade->pay_per_hour) ?> грн</p>

    <?php if ($user && $user->IsWorker()): ?>
        <?php if ($isJoined): ?>
            <div class="alert alert-success">Ви вже є членом цієї бригади.</div>
        <?php else: ?>
            <form method="post" action="/brigade/join/<?= htmlspecialchars($brigade->id) ?>">
                <button type="submit" class="btn btn-primary">Приєднатись до бригади</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
    <?php if(!\models\User::GetUser()->IsCostumer()): ?>
        <div class="alert alert-info">
            Для приєднання до бригади потрібно бути виконавцем і увійти в систему.
        </div>
    <?php else: ?>

    <?php endif;?>
    <?php endif; ?>
    <?php if (!empty($members) && $user && $user->IsCostumer() && !empty($tasksForDropdown)): ?>
        <h3 class="mt-4">Запропонувати роботу бригаді</h3>
        <form action="/offers/offerjob" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="task_id" class="form-label">Оберіть ваше завдання</label>
                    <select name="task_id" id="task_id" class="form-select" required>
                        <option value="" disabled selected>Оберіть завдання…</option>
                        <?php foreach ($tasksForDropdown as $task): ?>
                            <option value="<?= htmlspecialchars($task['id']) ?>">
                                <?= htmlspecialchars($task['short_text']) ?> (<?= htmlspecialchars($task['date']) ?>, <?= htmlspecialchars($task['cost']) ?>₴)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php foreach ($members as $worker): ?>
                <input type="hidden" name="worker_ids[]" value="<?= htmlspecialchars($worker->id) ?>">
            <?php endforeach; ?>

            <input type="hidden" name="costumer_id" value="<?= htmlspecialchars($user->id) ?>">
            <input type="hidden" name="brigadecall" value= "1">

            <div class="mt-3">
                <button type="submit" class="btn btn-warning">Запропонувати бригаді завдання</button>
            </div>
        </form>
    <?php endif; ?>

    <?php if (!empty($members)): ?>
        <h3 class="mt-4">Члени бригади</h3>
        <div class="list-group">
            <?php foreach ($members as $worker): ?>
                <?php $u = $worker->user; ?>
                <div class="list-group-item">
                    <strong>
                        <?= htmlspecialchars($u->name . ' ' . ($u->surname ?? '')) ?>
                    </strong><br>
                    Телефон: <?= htmlspecialchars($u->phone) ?><br>
                    Email: <?= htmlspecialchars($u->email) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted mt-4">У цій бригаді поки немає учасників.</p>
    <?php endif; ?>
</div>
