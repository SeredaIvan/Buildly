<?php $this->Title = 'Акаунт користувача';?>
<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
<section style="background-color: #eee;">
    <div class="container py-5">
        <?php ?>
        <!--зробити перевірку на те що воркер дозареєструвався  session('is_register_worker')-->
    <?php if(empty($user) ) {
        $user = \models\User::GetUser();
        //$is_register_worker=\core\Core::getInstance()->session->get('is_register_worker');
        if (!empty($user) && $user->IsWorker()) {
            $worker = \models\Worker::selectByUserId($user->id);
        }
    }
    ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div id="avatar">
                            <div id="avatar" class="position-relative">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                     class="rounded-circle img-fluid" style="width: 150px;" id="avatarImg">

                            </div>
                        </div>
                        <h5 class="my-3"><?=$user->name;?> <?=$user->surname?></h5>
                        <p class="text-muted mb-1"><?=$user->about?></p>
                        <p class="text-muted mb-4">____</p>
                        <?php if ($current = \models\User::GetUser()): ?>
                            <?php if ($current->IsCostumer() && $worker): ?>
                                <?php if (!empty($tasksForDropdown)): ?>
                                    <form action="/offers/offerjob" method="post" class="row g-2 justify-content-center align-items-end">
                                        <div class="col-md-6">
                                            <label for="task_id" class="form-label text-center w-100">Ваші завдання</label>
                                            <select name="task_id" id="task_id" class="form-select" required>
                                                <option value="" disabled selected>Оберіть завдання…</option>
                                                <?php foreach ($tasksForDropdown as $task): ?>
                                                    <option value="<?= htmlspecialchars($task['id']) ?>">
                                                        <?= htmlspecialchars($task['short_text']) ?>
                                                        (<?= htmlspecialchars($task['date']) ?>, <?= htmlspecialchars($task['cost']) ?>₴)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-2">
                                            <input type="hidden" name="costumer_id" value="<?= htmlspecialchars($current->id) ?>">
                                            <input type="hidden" name="worker_id" value="<?= htmlspecialchars($worker->id) ?>">
                                            <button type="submit" class="btn btn-warning px-4">Запропонувати роботу</button>
                                        </div>
                                    </form>

                                <?php else: ?>
                                    <div class="alert alert-info">
                                        У вас ще немає створених завдань.&nbsp;
                                        <a href="/tasks/add">Додати нове завдання</a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Прізвище Ім'я</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?=$user->name;?> <?=$user->surname?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Телефон</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?=$user->phone?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?=$user->email?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Вік</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?=$user->age?></p>
                            </div>
                        </div>

                    </div>
                </div>
                <?php if($user->IsWorker()):?>
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <?php //зробити шаблони для моделей??
                                if (!empty($worker)): ?>
                                <div class="col-sm-2 content-center">
                                    <p class="mb-0"> Категорії </p>
                                </div>

                                <div class="col-sm-10">

                                    <div class="row">
                                        <?php
                                        $categories = $worker->getArrayCategories();
                                        foreach ($categories as $category):
                                            $ucCategory = mb_strtoupper(mb_substr($category, 0, 1, "UTF-8"), "UTF-8") . mb_substr($category, 1, null, "UTF-8");
                                            ?>
                                            <div class="content-center p-1 border col-md-3 rounded-3 m-2 hover-shadow">
                                                <span class="text-muted mb-0 " style="font-size: 12px"><?=$ucCategory?></span>
                                            </div>
                                        <?php endforeach;?>

                                </div>
                                <?php elseif (empty($worker) ):?>
                                    <div class="col-sm-8 content-center">
                                        <p class="mb-0"> Ви не завершили реєстрацію спеціаліста</p>
                                    </div>
                                    <div class="col-sm-4">
                                            <a class="btn btn-danger" href="/worker/workerRegisterInfo">Дореєструватись</a>
                                    </div>
                                <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <?php endif;?>

            </div>
        </div>
    </div>
</section>
<script defer>
    let avatar = document.getElementById('avatar');
    let divImg=document.getElementById('divImg');
    let uploadForm = document.getElementById('uploadForm');
    let fileInput = document.getElementById('fileInput');

        let button=document.getElementById('pencilImg');
    avatar.addEventListener('mouseover', () => {
            divImg.style.backgroundColor = 'grey';
            button.style.display = 'block';
        });

    avatar.addEventListener('mouseout', () => {
            divImg.style.backgroundColor = '';
            button.style.display = 'none';
        });
    divImg.addEventListener('onclick', () => {
        uploadForm.style.display = 'block';
        fileInput.click();
    });
    button.addEventListener('onclick', () => {
        uploadForm.style.display = 'block';
        fileInput.click();
    });

</script>

