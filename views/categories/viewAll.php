<?php
$categories = $categories ?? [];
$Title = 'Категорії ';
?>
<h1>Categories</h1>
<style>
    .category-tile:hover {
        background-color: #e0e0e0;
        cursor: pointer;
        transition: 0.2s;
    }

</style>
<div class="row g-3">
    <?php foreach($categories as $category => $items): ?>
        <div class="col-md-4">
            <div class="border rounded-2 p-3 h-100">
                <h4 class="text-center mb-3"><?= htmlspecialchars($category) ?></h4>
                <?php foreach ($items as $item):
                    $formatted = mb_strtoupper(mb_substr($item, 0, 1, "UTF-8"), "UTF-8") . mb_substr($item, 1, null, "UTF-8");
                    $urlEncoded = urlencode($item);
                    ?>
                    <a href="/worker/findByCategories/<?= $urlEncoded ?>" class="text-decoration-none text-dark">
                        <div class="category-tile p-2 mb-2 border rounded bg-light text-center">
                            <?= htmlspecialchars($formatted) ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
