<?php
if (!isRole()) {
    die();
}
$promos = $database->query("SELECT * FROM `promo`")->fetchAll(2);
?>
<script src="assets/js/validation.js" defer></script>
<script src="assets/js/addPromo.js" defer></script>
<div class="add-course-bg" id="addPromo">
    <form action="" id="promo" name="addPromo" method="POST" class="add-course">
        <h2>ДОБАВИТЬ ПРОМОКОД</h2>
        <input type="text" name="name" placeholder="Промокод">
        <select name="type" id="">
            <option value="interest">Процентная скидка</option>
            <option value="Fixed">Фиксированная скидка</option>
        </select>
        <input type="text" name="num" id="sum" placeholder="Сумма">

        <input type="submit" value="создать">
        <label id="errorSettings" class="label">

        </label>
        <div class="krest" id="krest">
            ✕
        </div>
    </form>
</div>
<div class="container">
    <div class="profile">
        <h1>Промокоды</h1>
        <div class="settings-promo">
            <div class="promo-grid">
                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Промокод">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>

                </div>
                <div class="fortableheader">
                    <select name="" id="">
                        <option value="">Процентная скидка</option>
                        <option value="">Фиксированная скидка</option>
                    </select>
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>

                </div>
                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Значение">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <a class="user-header-flex" href="">
                    <p>ДЕЙСТВИЯ</p>
                </a>

            </div>
            <?php foreach ($promos as $promo): ?>
                <div class="promo-grid">
                    <div class="user-item">
                        <p class="id">
                            <?= $promo['name'] ?>
                        </p>
                    </div>
                    <div class="user-item">
                        <?php if ($promo['type'] == 'interest'): ?>
                            <p>Процентная скидка</p>
                        <?php else: ?>
                            <p>Фиксированная скидка</p>
                        <?php endif; ?>
                    </div>


                    <div class="user-item">
                        <p>
                            <?= $promo['sum'] ?><?php if ($promo['type'] == 'interest'): ?>%<?php else: ?>₽<?php endif; ?>
                        </p>
                    </div>
                    <div class="user-item">
                        <a href="actions/deletepromo.php?id=<?=$promo['id'] ?>"><img src="assets/images/admin-icons/XSquare.png" alt=""></a>
                    </div>
                </div>
            <?php endforeach; ?>


            <div class="promo-grid">
                <p class="go-to" id="addcourse">+ Создать промокод</p>
            </div>
        </div>

    </div>
</div>

<script>
    const sum = document.getElementById('sum');
    sum.addEventListener('input', function () {
        let inputValue = sum.value;
        inputValue = inputValue.replace(/\D/g, '')
        sum.value = inputValue;
    });
</script>