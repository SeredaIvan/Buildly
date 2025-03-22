<?php
    $workers = $workers ?? [];
    $Title = 'Find All ';
?>
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
