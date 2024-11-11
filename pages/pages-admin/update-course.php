<?php
if (!isRole()) {
    die();
}
$course = $database->query("SELECT * FROM `courses` WHERE `id` = " . $_GET['id'])->fetch(2);
$users = $database->query("SELECT * FROM `users`")->fetchAll(2);
$lessons = $database->query("SELECT * FROM `lessons` WHERE `courseId` = " . $course['id'])->fetchAll(2);
?>
<div class="update-course">
    <div class="update-course-left">
        <p class="url">Курсы /
            <?= $course['id'] ?> /
            <?= $course['name'] ?>
        </p>

        <form action="actions/updateCourse.php?id=<?= $course['id'] ?>" method="POST" class="about-course"
            enctype="multipart/form-data">
            <p id="imgname"></p>
            <img class="about-course-img" src="
            <?php if (isset($course['img'])): ?>
                <?= $course['img'] ?>
                <?php else: ?>
            assets/images/course/baner.png
            <?php endif; ?>
            " alt="">
            <input id="file" name="image" type="file">
            <label for="file">+</label>
            <h4>Лечение ОКР</h4>
            <div class="course-update-btn">
                <p>Преподаватель:</p>

                <select name="teacher" id="">
                    <?php foreach ($users as $teacher): ?>
                        <?php if ($teacher['role'] == '3'): ?>
                            <option value="<?= $teacher['id'] ?>">
                                <?= $teacher['surname'] ?>
                                <?= $teacher['name'] ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="course-update-btn">
                <p>Куратор(-ы):</p>
                <select name="curator" id="">
                    <?php foreach ($users as $teacher): ?>
                        <?php if ($teacher['role'] == '4'): ?>
                            <option value="<?= $teacher['id'] ?>">
                                <?= $teacher['surname'] ?>
                                <?= $teacher['name'] ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="course-update-btn">
                <p>Стоимость:</p>
                <input type="text" id="price" name="price" value="<?= $course['price'] ?>">
                <span> ₽ </span>

            </div>
            <div class="course-update-btn">
                <p>Публикация:</p>
                <select name="public" id="">
                    <option <?php if ($course['public'] == 'да')
                        echo 'selected' ?> value="да">Да</option>
                        <option <?php if ($course['public'] == 'нет')
                        echo 'selected' ?> value="нет">Нет</option>
                    </select>

                </div>
                <div class="course-update-btn">
                    <p>Описание:</p>
                    <textarea name="about" id="" cols="10" rows="10"><?= $course['about'] ?></textarea>

            </div>
            <?php if ($course['deadline'] == 'on'): ?>
                <div class="course-update-btn">
                    <p>Даты:</p>
                    <input type="date" name="dateFrom" value="<?= $course['dateFrom'] ?>">
                    <input type="date" name="dateTo" value="<?= $course['dateTo'] ?>">
                </div>
            <?php endif; ?>
            <input type="submit">
        </form>


        <div class="students">
            <p class="url">Ученики</p>
            <div class="students-info">
                <div class="students-grid">
                    <h3>ID</h3>
                    <h3>ФИО</h3>
                    <h3>ДЕЙСТВИЯ</h3>
                </div>
                <?php
                // Получаем все записи из таблицы Purchased, где courseId соответствует запрошенному курсу
                $purchasedRecords = $database->query("SELECT * FROM `Purchased` WHERE `courseId` = " . $_GET['id'])->fetchAll(2);

                foreach ($purchasedRecords as $purchasedRecord) {
                    // Для каждой записи из таблицы Purchased получаем информацию о пользователе
                    $userId = $purchasedRecord['userId'];
                    $userInfo = $database->query("SELECT * FROM `users` WHERE `id` = $userId")->fetch(2);
                    ?>
                    <div class="students-grid">
                        <p><?= $userInfo['id'] ?></p>
                        <p><?= $userInfo['name'] . ' ' . $userInfo['surname'] ?></p>
                        <a onclick="return confirm('Вы уверены что хотите удалить пользователя с курса?')" href="actions/deleteFromCourse.php?userid=<?=$userInfo['id']?>&courseid=<?=$_GET['id']?>"><img src="assets/images/admin-icons/XSquare.png" alt=""></a>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>
    <div class="update-course-right">
        <p class="url">Уроки</p>
        <div class="update-lessons">
            <div class="lessons-grid">
                <h3>№</h3>
                <h3>НАЗВАНИЕ</h3>
                <h3>ВИДЕО</h3>
                <h3>ДЗ</h3>
                <h3>ДЕЙСТВИЯ</h3>
            </div>
            <?php foreach ($lessons as $lesson): ?>
                <?php $homework = $database->query("SELECT * FROM `homeworks` WHERE `lessonId` = " . $lesson['id'])->fetchAll(2); ?>
                <div class="lessons-grid">
                    <p class="circle"><?= $lesson['id'] ?></p>
                    <div class="url"><?= $lesson['name'] ?></div>


                    <?php if ($lesson['video'] === null): ?>
                        <img src="assets/images/admin-icons/nothink.png" alt="">
                    <?php else: ?>
                        <img src="assets/images/answers/correct.png" alt="">
                    <?php endif; ?>

                    <?php if (empty($homework)): ?>
                        <img src="assets/images/admin-icons/nothink.png" alt="">
                    <?php else: ?>
                        <img src="assets/images/answers/correct.png" alt="">
                    <?php endif; ?>



                    <div class="actions">
                        <a onclick="return confirm('Вы правда хотите удалить урок?')" href="actions/deleteHomework.php?id=<?=$lesson['id']?>&courseid=<?=$_GET['id']?>">
                            <img src="assets/images/admin-icons/XSquare.png" alt="">
                        </a>
                        <a href="?page=updateLesson&id=<?= $lesson['id'] ?>">
                        <img src="assets/images/admin-icons/edit.png" alt="">
                    </a>
                        
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<script>
    const price = document.getElementById('price');
    price.addEventListener('input', function () {
        let inputValue = price.value;
        inputValue = inputValue.replace(/\D/g, '')
        price.value = inputValue;
    });
</script>

<script>
    let img = document.getElementById('file')
    img.addEventListener('change', function () {
        if (img.files[0]) {
            document.getElementById('imgname').innerHTML = "Изображение добавлено: " + img.files[0].name;
        } else {
            document.getElementById('imgname').innerHTML = "Файл не выбран";
        }
    })

</script>