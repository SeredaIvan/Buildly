<style>
    #city-list {
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        position: absolute;
        z-index: 100;
        background-color: white;
        width: 100%;
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
    <form id="filter-form">
        <div class="row mb-3 p-4">
            <div class="col-md-2">
                <input type="number" name="pay_per_hour_min" class="form-control" placeholder="Мінімальна оплата" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="pay_per_hour_max" class="form-control" placeholder="Максимальна оплата" required>
            </div>
            <div class="col-md-4">
                <?php
                $categories = \core\Config::getInstance()->paramsCategories[0];
                ?>
                <select name="category" class="form-select" required>
                    <option selected>Виберіть категорію</option>
                    <?php foreach ($categories as $categoryGroup): ?>
                        <?php foreach ($categoryGroup as $key => $value): ?>
                            <option value="<?= $value ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 position-relative">
                <input class="form-control" name="city" type="text" id="city-input" placeholder="Введіть місто..." autocomplete="off" required>
                <div id="city-list"></div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-warning w-100">Знайти</button>
            </div>
        </div>
    </form>
</div>

<div class="row m-3" id="workers-container"></div>

<script>
    const cities = ["Київ", "Львів", "Одеса", "Харків", "Дніпро", "Запоріжжя", "Миколаїв", "Чернівці", "Полтава",
        "Суми", "Івано-Франківськ", "Вінниця", "Черкаси", "Житомир", "Хмельницький", "Рівне", "Тернопіль",
        "Луцьк", "Кропивницький", "Ужгород", "Донецьк", "Луганськ", "Севастополь"];

    const input = document.getElementById("city-input");
    const cityList = document.getElementById("city-list");

    input.addEventListener("input", function() {
        const query = input.value.trim().toLowerCase();
        cityList.innerHTML = "";

        if (query) {
            const filteredCities = cities.filter(city => city.toLowerCase().includes(query));

            filteredCities.forEach(city => {
                const div = document.createElement("div");
                div.classList.add("city-item");
                div.textContent = city;
                div.addEventListener("click", () => {
                    input.value = city;
                    cityList.innerHTML = "";
                });
                cityList.appendChild(div);
            });
        }
    });

    document.addEventListener("click", (event) => {
        if (!cityList.contains(event.target) && event.target !== input) {
            cityList.innerHTML = "";
        }
    });

    document.getElementById("filter-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new URLSearchParams(new FormData(this)).toString();
        document.getElementById("workers-container").innerHTML = "";

        fetch("/worker/findByCategories", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData
        })
            .then(response => response.json())
            .then(data => {

                if (data.error) {
                    alert(data.error);
                    return;
                }

                if (!Array.isArray(data)) {
                    alert("Жодного результату не знайдено.");
                    return;
                }

                const container = document.getElementById("workers-container");

                data.forEach(worker => {
                    const card = document.createElement("div");
                    card.classList.add("col-md-3");

                    const categories = worker.categories.split(",").map(category =>
                        `<span class="badge bg-secondary m-1">${category.trim()}</span>`
                    ).join('');

                    card.innerHTML = `
            <div class="card border rounded-3 mb-2" style="height: 500px">
                <div class="p-4">
                    <h5>${worker.user.name} ${worker.user.surname}</h5>
                    <p class="text-muted">${worker.user.city}</p>
                    <div class="mb-3">
                        <strong>Категорії:</strong>
                        <div class="d-flex flex-wrap">
                            ${categories}
                        </div>
                    </div>
                    <p><strong>${worker.pay_per_hour} грн/год</strong></p>
                    <button class="btn btn-warning w-100">Замовити</button>
                </div>
            </div>`;

                    container.appendChild(card);
                });
            })
            .catch(error => {
                console.error("Помилка отримання даних:", error);
                alert("Сталася помилка при отриманні даних.");
            });
    });

</script>
