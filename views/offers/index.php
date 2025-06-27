<div class="container my-4">
    <h2>Перегляд пропозицій</h2>

    <?php if (!empty($offersForCostumer)): ?>
        <div class="list-group mb-4">
            <?php foreach ($offersForCostumer as $offer): ?>
                <?php
                $workerUser = $offer['workerUser'] ?? null;
                ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="/tasks/view/<?= htmlspecialchars($offer['id_task']) ?>">
                            <?= htmlspecialchars($offer['taskTitle'] ?? 'Завдання') ?>
                        </a>
                        <br>
                        Виконавець:
                        <?php if ($workerUser): ?>

                            <a href="/users/see/<?= htmlspecialchars($workerUser['id'] ?? '') ?>">
                                <?= htmlspecialchars(trim(($workerUser['name'] ?? '') . ' ' . ($workerUser['patronymic'] ?? '') . ' ' . ($workerUser['surname'] ?? ''))) ?>
                            </a>
                    </div>
                    <div>
                        <?php if (isset($offer['is_accepted']) && $offer['is_accepted'] == 1): ?>
                            <span class="badge bg-success">Прийнято</span>
                        <?php else: ?>
                            <form method="post" action="/offers/acceptOffer" style="display:inline;">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                                <button type="submit" class="btn btn-success btn-sm">✓ Прийняти</button>
                            </form>
                            <form method="post" action="/offers/declineOffer" style="display:inline;">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">✗ Відхилити</button>
                            </form>
                        <?php endif; ?>
                    </div>
                        <?php else: ?>
                            <span class="text-muted">Виконавець відминив </span>
                </div>
                        <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($offersForWorker)): ?>
        <div class="list-group">
            <?php foreach ($offersForWorker as $offer): ?>
                <?php
                $costumerUser = $offer['costumerUser'] ?? null;
                ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="/tasks/view/<?= htmlspecialchars($offer['id_task']) ?>">
                            <?= htmlspecialchars($offer['taskTitle'] ?? 'Завдання') ?>
                        </a>
                        <br>
                        Замовник:
                        <?php if ($costumerUser): ?>
                            <a href="/users/see/<?= htmlspecialchars($costumerUser['id'] ?? '') ?>">
                                <?= htmlspecialchars(trim(($costumerUser['name'] ?? '') . ' ' . ($costumerUser['patronymic'] ?? '') . ' ' . ($costumerUser['surname'] ?? ''))) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Замовник не вказаний</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($offer['is_accepted']) && $offer['is_accepted'] == 1): ?>
                            <span class="badge bg-success">Прийнято</span>
                        <?php else: ?>
                            <form method="post" action="/offers/acceptOffer" style="display:inline;">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                                <button type="submit" class="btn btn-success btn-sm">✓ Прийняти</button>
                            </form>
                            <form method="post" action="/offers/declineOffer" style="display:inline;">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">✗ Відхилити</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Пропозицій для вас немає.</p>
    <?php endif; ?>
</div>
