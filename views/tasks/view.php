<?php
/** @var $task \models\Tasks */
$this->Title = "Завдання №" . htmlspecialchars($task->id);
?>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Завдання №<?= htmlspecialchars($task->id?? '') ?></h4>
        </div>
        <div class="card-body">
            <p><strong>Короткий опис:</strong> <?= htmlspecialchars($task->short_text?? '') ?></p>
            <p><strong>Повний опис:</strong> <?= nl2br(htmlspecialchars($task->full_text?? '')) ?></p>
            <p><strong>Ціна:</strong> <?= htmlspecialchars($task->cost?? '') ?> грн</p>
            <p><strong>Дата виконання:</strong> <?= htmlspecialchars($task->date?? '') ?></p>
            <p><strong>Місто:</strong> <?= htmlspecialchars($task->city?? '') ?></p>
            <a href="/tasks/all" class="btn btn-secondary mt-3">Назад до всіх завдань</a>
        </div>
    </div>
</div>
