<?php $this->Title='Реєстрація'; ?>
<div class="content-center">
<div class="form-register">
    <form>
        <h1>Buildly</h1>
        <h1 class="h3 mb-3 fw-normal">Реєстрація</h1>
        <div class="mb-2 form-floating">
            <input type="text" class="form-control" id="floatingInputName" placeholder="Іван">
            <label for="floatingInputName">Введіть ваше ім'я</label>
        </div>
        <div class="mb-2 form-floating">
            <input type="text" class="form-control" id="floatingInputSurname" placeholder="Ковальчук">
            <label for="floatingInputSurname">Введіть ваше прізвище</label>
        </div>
        <div class="mb-2 form-floating">
            <input type="email" class="form-control" id="floatingInputEmail" placeholder="name@gmail.com">
            <label for="floatingInputEmail">Введіть свій email</label>
        </div>
        <div class="mb-2 form-floating">
            <input type="password" class="form-control" id="floatingInputPass1" placeholder="">
            <label for="floatingInputPass1">Введіть новий пароль</label>
        </div>
        <div class="mb-2 form-floating">
            <input type="password" class="form-control" id="floatingInputPass2" placeholder="">
            <label for="floatingInputPass2">Повторіть пароль</label>
        </div>
        <div class="mb-2 form-floating">
            <input type="number" class="form-control" id="floatingInputAge" placeholder="">
            <label for="floatingInputAge">Введіть свій вік</label>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" value="user" id="radioUser">
                <label class="form-check-label" for="radioUser">
                    Я замовник
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" value="worker" id="radioWorker">
                <label class="form-check-label" for="radioWorker">
                    Я спеціаліст
                </label>
            </div>
        </div>

        <button class="w-100 btn btn-lg btn-warning" type="submit">Зареєструватись</button>
        <p class="mt-5 mb-3 text-muted">© 2024</p>
    </form>
</div>
</div>