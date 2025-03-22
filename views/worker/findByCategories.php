<?php
$workers = $workers ?? [];
$Title = 'Find By Categories ';
?>
<style>
    #city-list {
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        position: absolute;
        z-index: 100;
        background-color: white;
        width: 200px;
    }
    .city-item {
        padding: 8px;
        cursor: pointer;
    }
    .city-item:hover {
        background-color: #f1f1f1;
    }
</style>
<div class="row mb-3">
    <form action="/worker/findByCategories" method="post">
        <div class="row mb-3 p-4">
            <div class="col-md-2">
                <input type="number" id="pay_per_hour_min" class="form-control"  placeholder="Введіть мінімальну оплату за год" >
            </div>
            <div class="col-md-2">
                <input type="number" id="pay_per_hour_max" class="form-control" placeholder="Введіть максимальну оплату за год"  >
            </div>
            <div class="col-md-4">
            <?php $categories=\core\Config::getInstance()->paramsCategories[0]; ?>
                <select class="form-select" aria-label="Default select example" >
                    <option selected>Виберіть категорію</option>
                    <?php foreach ($categories as $category=>$countRadio):?>
                        <?php  foreach ($countRadio as $key=>$value) :?>
                            <option value="<?=$value?>"><?=$value?></option>
                        <?php endforeach?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-4">
                <input class="form-control"  type="text" id="city-input" placeholder="Введіть місто..." autocomplete="off">
                <div id="city-list"></div>
            </div>
        </div>
    </form>
</div>
<div class="row m-3">
    <?php foreach ($workers as $worker):?>

        <div class="col-md-3 " >
            <div class="card border rounded-3 mb-2" style="height: 500px">
                <div class="row p-4">

                    <div class="col-md-12 pb-4"><span><?=$worker->user->name?> <?=$worker->user->surname?></span></div>
                    <div class="p-2">
                        <div class="content-center col-md-12 p-1 border rounded-3  hover-shadow mb-3">
                            <span class="text-muted mb-0 " style="font-size: 12px"><?=$worker->user->city?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row " style="height: 200px">
                            <div class="col-md-12 content-center mb-4">Категорії користувача</div>
                            <?php
                            $categories = $worker->getArrayCategories();
                            $i=0;
                            foreach ($categories as $category):
                                $ucCategory = mb_strtoupper(mb_substr($category, 0, 1, "UTF-8"), "UTF-8") . mb_substr($category, 1, null, "UTF-8");
                                $i++;
                                if ($i==5){
                                    break;
                                }
                                ?>
                                <div class="content-center p-1 border col-md-3 rounded-3 mb-4 hover-shadow" style="margin-right: 3px">
                                    <span class="text-muted mb-0 " style="font-size: 12px"><?=$ucCategory?></span>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="col-md-12 content-center">
                        <p class="p-3 mb-0"><?=$worker->pay_per_hour?> грн в год.</p>
                    </div>
                    <div class="col-md-12 content-center">
                        <button class="btn btn-warning">Замовити роботу</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach;?>
</div>
<script >
    const cities = [
        "Київ", "Львів", "Одеса", "Харків", "Дніпро", "Запоріжжя", "Миколаїв", "Чернівці", "Полтава",
        "Суми", "Івано-Франківськ", "Вінниця", "Черкаси", "Житомир", "Хмельницький", "Рівне", "Тернопіль",
        "Луцьк", "Кропивницький", "Ужгород", "Миколаїв", "Донецьк", "Луганськ", "Миколаїв", "Севастополь"
    ];
    const input = document.getElementById("city-input");
    const cityList = document.getElementById("city-list");

    input.addEventListener("input", function() {
        const query = input.value.toLowerCase();
        cityList.innerHTML = "";

        if (query) {
            const filteredCities = cities.filter(city => city.toLowerCase().includes(query));

            filteredCities.forEach(city => {
                const div = document.createElement("div");
                div.classList.add("city-item");
                div.textContent = city;
                div.addEventListener("click", function() {
                    input.value = city;
                    cityList.innerHTML = "";
                });
                cityList.appendChild(div);
            });
        }
    });

    document.addEventListener("click", function(event) {
        if (!cityList.contains(event.target) && event.target !== input) {
            cityList.innerHTML = "";
        }
    });
</script>
