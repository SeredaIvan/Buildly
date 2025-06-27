<?php
$this->Title = 'Створення бригади';
$categories = \core\Config::getInstance()->paramsCategories[0];
?>

<div class="container my-4">
    <h2>Створення бригади</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="pay_per_hour" class="form-label">Оплата за годину (грн)</label>
            <input type="number" class="form-control" name="pay_per_hour" id="pay_per_hour"
                   value="<?= htmlspecialchars($oldData['pay_per_hour'] ?? '') ?>" min="0" step="0.01" required>
        </div>

        <div class="content-center rounded-3 mb-3 mt-4 shadow p-3 border">
            <h4>Оберіть категорії</h4>
            <div class="row">
                <?php foreach ($categories as $group => $items): ?>
                    <div class="col-md-4">
                        <strong><?= htmlspecialchars($group) ?></strong>
                        <?php foreach ($items as $item): ?>
                            <?php
                            $checked = in_array($item, $oldData['categories'] ?? []) ? 'checked' : '';
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="categories[]" value="<?= htmlspecialchars($item) ?>" id="cat_<?= md5($item) ?>" <?= $checked ?>>
                                <label class="form-check-label" for="cat_<?= md5($item) ?>">
                                    <?= htmlspecialchars(ucfirst($item)) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-warning">Створити бригаду</button>
    </form>
</div>
