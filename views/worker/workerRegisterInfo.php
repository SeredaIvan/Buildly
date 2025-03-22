<?php
// Підключення файлу конфігурації
include_once 'config/config.php';

// Ваша логіка для обробки форм та виводу
$this->Title = 'Реєстрація спеціаліста';
\core\Messages::writeMessages();

?>
<br>
<div class="content-center">
    <div class="form-register">
        <form method="post" action="">
            <h1>Buildly</h1>
            <h1 class="h3 mb-3 fw-normal">Реєстрація спеціаліста</h1>
            <div class="mb-2 form-floating shadow rounded-3">
                <input name="pay_per_hour" type="number" class="form-control" id="floatingInputPayPerHour" placeholder="75.5">
                <label for="floatingInputPayPerHour">Введіть бажану оплату за годину в грн</label>
            </div>
            <div class="content-center rounded-3 mb-3 mt-4 shadow p-3 border"> Виберіть категорії для пошуку роботи</div>
            <?php $categories=\core\Config::getInstance()->paramsCategories[0]; ?>
            <div class="row mb-3 mt-4 shadow rounded-3 ">
            <?php foreach($categories as $category=>$countRadio) {

                echo "<div class='col-md-4 themed-grid-col border rounded-2 '>
                <div class='content-center pt-3 p-2 ' ><h4 class='font-weight-bold'>{$category}</h4></div>
                ";
                $i=0;
                foreach ($countRadio as $key=>$value) {
                    $ucValue = mb_strtoupper(mb_substr($value, 0, 1, "UTF-8"), "UTF-8") . mb_substr($value, 1, null, "UTF-8");
                    echo "
                        <div class='themed-grid-col text-start p-2 pb-3' >
                            <input class='form-check-input' type='radio' name='{$category}{$i}'' value='{$value}' id='radioUser{$i}{$category}'>
                            <label class='form-check-label' for='radioUser{$i}{$category}'>{$ucValue}</label>
                        </div>";
                    $i++;
                }
                echo "</div>";
            }
            ?>
            </div>
            <button class="w-100 btn btn-lg btn-warning" type="submit">Ввійти</button>
            <p class="mt-5 mb-3 text-muted">© 2024</p>
        </form>
    </div>
</div>
