<?php $this->Title='Вхід';

?>
<?php
$messages=\core\Messages::getMessages();
if(!empty($messages)){
    foreach ($messages as $mess){
        echo $mess;
    }
}?>
<br>
<div class="content-center">
    <div class="form-register">
        <form method="post" action="">
            <h1>Buildly</h1>
            <h1 class="h3 mb-3 fw-normal">Вхід</h1>
            <div class="mb-2 form-floating">
                <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="name@gmail.com">
                <label for="floatingInputEmail">Введіть свій email</label>
            </div>
            <div class="mb-2 form-floating">
                <input name="password" type="password" class="form-control" id="floatingInputPass1" placeholder="">
                <label for="floatingInputPass1">Введіть пароль</label>
            </div>

            <button class="w-100 btn btn-lg btn-warning" type="submit">Ввійти</button>
            <p class="mt-5 mb-3 text-muted">© 2024</p>
        </form>
    </div>
</div>