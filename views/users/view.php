<?php $this->Title = 'Акаунт користувача';?>
<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
<section style="background-color: #eee;">
    <div class="container py-5">
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
                                <div id="divImg" class="hover-shadow-lg rounded-circle content-center" style="height: 60px;width: 60px ; background-color: white ;position: absolute; bottom: 5px; right: 5px;">
                                    <img class=" " id="pencilImg" src="/media/pencil.svg" width="40" height="40" style=" background-color: white; display: none;">
                                    <form id="uploadForm" style="display: none;" enctype="multipart/form-data">
                                        <input type="file" id="fileInput" name="file" accept="image/*">
                                        <button type="submit" class="btn btn-warning">Завантажити</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h5 class="my-3"><?=$user->name;?> <?=$user->surname?></h5>
                        <p class="text-muted mb-1"><?=$user->about?></p>
                        <p class="text-muted mb-4">____</p>
                        <?php if (!empty($tasks)&&$user->IsWorker()&&\models\User::GetUser()->IsCostumer()): ?>
                            <div class="d-flex justify-content-center mb-2">

                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning">Замовити роботу</button>

                                <!--<form action="/offers/offerjob" method="post">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']?>">
                                    <input type="hidden" name="costumer_id" value="<?php $user->id ?? ''?>">
                                    <input type="hidden" name="worker_id" value="<?php $worker->id ?? ''?>">
                                    <button type="submit" class="btn btn-warning">Запропонувати кандидатуру</button>
                                </form>-->
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!--
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fas fa-globe fa-lg text-body">Додати кількість виконаних робіт для воркера і кількість замовлень для клієнта</i>
                                <p class="mb-0" style="color: red">!!!!!!!!</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fab fa-github fa-lg text-body">Додати відгуки для воркера</i>
                                <p class="mb-0"  style="color: red">!!!!!!!!</p>
                            </li>
                        </ul>
                    </div>
                </div>
                -->
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
                                <?php elseif (empty($worker)):?>
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
                <?php if (!empty($worker)):?>
                <!--
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                                </p>
                                <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                <div class="progress rounded mb-2" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                                </p>
                                <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                <div class="progress rounded mb-2" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
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

