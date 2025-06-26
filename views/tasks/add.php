<?php
/** @var array|null $errors */
/** @var array|null $oldData */
/** @var \models\User $user */
?>
<div class="container my-4">
<h2>Додати завдання</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if($user->IsCostumer()) :?>
<form method="post" action="/tasks/add">
    <div class="mb-3">
        <label for="short_text" class="form-label">Короткий опис</label>
        <input type="text" class="form-control" id="short_text" name="short_text"
               value="<?= htmlspecialchars($oldData['short_text'] ?? '') ?>" required maxlength="255">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Опис завдання</label>
        <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($oldData['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="cost" class="form-label">Вартість</label>
        <input type="number" class="form-control" id="cost" name="cost"
               value="<?= htmlspecialchars($oldData['cost'] ?? '') ?>" step="0.01" min="0" required>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Дата виконання</label>
        <input type="date" class="form-control" id="date" name="date"
               value="<?= htmlspecialchars($oldData['date'] ?? '') ?>" required>
    </div>



    <button type="submit" class="btn btn-warning">Додати завдання</button>
</form>
</div>
<?php endif;?>