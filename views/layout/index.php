<?php

use core\Config;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $Title ?? 'Default Title' ?></title>
</head>
<body>
<div class="container-fluid">
    <div class="header-div"></div>
    <header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-4 mb-2 mb-md-0 text-dark text-decoration-none">
            <h1>Buildy</h1>
        </a>

        <?php $user = \models\User::GetUser(); ?>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-secondary">Головна</a></li>
            <?php if (!\models\User::IsLogged()): ?>
                <li><a href="/worker/findAll" class="nav-link px-2 link-dark">Знайти спеціаліста</a></li>
                <li><a href="/register/" class="nav-link px-2 link-dark">Стати спеціалістом</a></li>
            <?php elseif ($user->IsWorker()): ?>
                <li><a href="#" class="nav-link px-2 link-dark">Знайти роботу</a></li>

            <?php elseif ($user->IsCostumer()): ?>
                <li><a href="/worker/findAll" class="nav-link px-2 link-dark">Знайти спеціаліста</a></li>
                <li><a href="/categories" class="nav-link px-2 link-dark">Категорії</a></li>
            <?php endif; ?>
            <li><a href="/about" class="nav-link px-2 link-dark">Про нас</a></li>
        </ul>

        <?php if (!\models\User::IsLogged()): ?>
            <div class="col-md-3 text-end ms-auto">
                <a href="/users/login" class="btn btn-outline-warning me-2">Ввійти</a>
                <a href="/users/registration" class="btn btn-warning">Реєстрація</a>
            </div>
        <?php else: ?>
            <div class="col-md-2 text-end ms-auto">
                <div class="flex-shrink-0 dropdown">
                    <a href="/users/view" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if ($user->IsWorker()): ?>
                        <img src="/media/worker.svg" alt="mdo" width="32" height="32" class="rounded-circle">
                        <?php elseif ($user->IsCostumer()): ?>
                            <img src="/media/consumer.svg" alt="mdo" width="32" height="32" class="rounded-circle">
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="/users/view">Переглянути акаунт</a></li>
                        <!--<li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>-->
                        <li><a class="dropdown-item" href="/users/signOut">Sign out</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </header>
</div>

<?php
\core\Messages::writeMessages();
?>

<main>
    <?= $Content ?? 'Default Content' ?>
</main>
<footer class="container py-5">
    <div class="footer-div"></div>
    <div class="row">
        <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">© 2017–2021</small>
        </div>
        <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary" href="#">Cool stuff</a></li>
                <li><a class="link-secondary" href="#">Random feature</a></li>
                <li><a class="link-secondary" href="#">Team feature</a></li>
                <li><a class="link-secondary" href="#">Stuff for developers</a></li>
                <li><a class="link-secondary" href="#">Another one</a></li>
                <li><a class="link-secondary" href="#">Last time</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary" href="#">Resource name</a></li>
                <li><a class="link-secondary" href="#">Resource</a></li>
                <li><a class="link-secondary" href="#">Another resource</a></li>
                <li><a class="link-secondary" href="#">Final resource</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary" href="#">Business</a></li>
                <li><a class="link-secondary" href="#">Education</a></li>
                <li><a class="link-secondary" href="#">Government</a></li>
                <li><a class="link-secondary" href="#">Gaming</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                <li><a class="link-secondary" href="#">Team</a></li>
                <li><a class="link-secondary" href="#">Locations</a></li>
                <li><a class="link-secondary" href="#">Privacy</a></li>
                <li><a class="link-secondary" href="#">Terms</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>
