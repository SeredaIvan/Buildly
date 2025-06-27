<?php


use core\Messages;
use models\User;
use models\Worker;

Messages::writeMessages();

?>
<div class="container my-4">
    <h2>Перегляд пропозицій</h2>

    <?php if (!empty($offersForCostumer)): ?>
        <h4 class="mt-4">Ваші пропозиції</h4>
        <div class="list-group mb-5">
            <?php foreach ($offersForCostumer as $offer): ?>
                <?php $workerUser = $offer['workerUser'] ?? null; ?>

                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="/tasks/view/<?= htmlspecialchars($offer['id_task'] ?? '') ?>">
                            <?= htmlspecialchars($offer['taskTitle'] ?? 'Завдання') ?>
                        </a>
                        <br>

                        <?php if ($workerUser): ?>
                            Виконавець:
                            <a href="/users/see/<?= htmlspecialchars($workerUser['id'] ?? '') ?>">
                                <?= htmlspecialchars(trim(
                                    ($workerUser['name'] ?? '') . ' ' .
                                    ($workerUser['patronymic'] ?? '') . ' ' .
                                    ($workerUser['surname'] ?? '')
                                )) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-danger">Виконавець відмовив</span>
                        <?php endif; ?>


                    </div>

                    <div>
                        <?php if (isset($offer['is_accepted']) && $offer['is_accepted'] == 1): ?>
                            <span class="badge bg-success">Прийнято</span>
                        <?php elseif ($workerUser): ?>
                            <form method="post" action="/offers/acceptOffer" class="d-inline">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id'] ?? '') ?>">
                                <button type="submit" class="btn btn-success btn-sm">✓ Прийняти</button>
                            </form>
                            <form method="post" action="/offers/declineOffer" class="d-inline">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id'] ?? '') ?>">
                                <button type="submit" class="btn btn-danger btn-sm">✗ Відхилити</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($offersForWorker)): ?>
        <h4 class="mt-4">Ваші пропозиції </h4>
        <div class="list-group">
            <?php foreach ($offersForWorker as $offer): ?>
                <?php $costumerUser = $offer['costumerUser'] ?? null; ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="/tasks/view/<?= htmlspecialchars($offer['id_task'] ?? '') ?>">
                            <?= htmlspecialchars($offer['taskTitle'] ?? 'Завдання') ?>
                        </a>
                        <br>

                        <?php if ($costumerUser): ?>
                            Замовник:
                            <a href="/users/see/<?= htmlspecialchars($costumerUser['id'] ?? '') ?>">
                                <?= htmlspecialchars(trim(
                                    ($costumerUser['name'] ?? '') . ' ' .
                                    ($costumerUser['patronymic'] ?? '') . ' ' .
                                    ($costumerUser['surname'] ?? '')
                                )) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-danger">Замовник відмовив</span>
                        <?php endif; ?>
                        <?php if ($offer['brigadecall']==1): ?>
                            <span class="m-2 badge bg-info text-black"> Бригадна пропозиція</span>

                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($offer['is_accepted']) && $offer['is_accepted'] == 1): ?>
                            <span class="badge bg-success">Прийнято</span>
                        <?php elseif ($costumerUser): ?>
                            <form method="post" action="/offers/acceptOffer" class="d-inline">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id'] ?? '') ?>">
                                <button type="submit" class="btn btn-success btn-sm">✓ Прийняти</button>
                            </form>
                            <form method="post" action="/offers/declineOffer" class="d-inline">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id'] ?? '') ?>">
                                <button type="submit" class="btn btn-danger btn-sm">✗ Відхилити</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($offersForCostumer) && empty($offersForWorker)): ?>
        <div class="alert alert-info">Пропозицій для вас немає.</div>
    <?php endif; ?>
</div>
