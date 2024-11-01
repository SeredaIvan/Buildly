<?php $Title='Main page';
?>
    <div class="site-index-div p-5 mb-4 m-5  rounded-3 content-center">
        <div class="container-fluid  blur-background p-5 content-center">
            <h1 class="display-5 fw-bold ">Знаходьте найкращих будівельних спеціалістів з Buildy</h1>
            <p class="col-md-8 fs-4 ">Обирайте професіоналів для будь-яких будівельних проектів - від ремонту до новобудов.</p>
        </div>
            <div class="flex-center mt-2">
                <a href="/worker/findByCategories" class="btn btn-warning btn-lg flex-center-item" type="button">Знайти спеціаліста</a>
                <a href="/users/registration" class="btn btn-warning btn-lg flex-center-item" type="button">Запропонувати послуги</a>
            </div>
    </div>
<?php
    if (\models\User::IsLogged()){
        include_once "add_task.php";
    }
?>

