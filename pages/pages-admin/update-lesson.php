<?php if (isset($_GET['id'])) {
    $lesson = $database->query("SELECT * FROM `lessons` WHERE `id` = " . $_GET['id'])->fetch(2);
    $course = $database->query("SELECT * FROM `courses` WHERE `id` = " . $lesson['courseId'])->fetch(2);
    $homework = $database->query("SELECT * FROM `homeworks` WHERE `lessonId` = " . $_GET['id'] )->fetchAll(2);

} ?>

<div class="update-course">
    <div class="update-course-left">
        <p class="url">Курсы /
            <?= $course['id'] ?> /
            <?= $course['name'] ?> /
            <?= $lesson['name'] ?>
        </p>
        <form class="about-course" method="POST" enctype="multipart/form-data" id="updateLesson"
            action="actions/updateLesson.php?id=<?= $lesson['id'] ?>">
            <p id="imgname"></p>
            <img class="about-course-img" src="assets/images/course/baner.png" alt="">
            <input id="file" name="video" type="file">
            <label for="file">+</label>
            <div class="bootom-line">
                <h4>
                    <?= $lesson['name'] ?>
                </h4>
                <h4>№
                    <?= $lesson['id'] ?>
                </h4>
            </div>

            <div class="lesson-update-btn">
                <p>Видео:</p>
                <div class="lesson-box">
                    <input type="text" value="key">
                </div>

            </div>
            <div class="lesson-update-btn">
                <p>Д/З:</p>
                <div class="lesson-box">
                    <?php if (empty($homework)): ?>
                        <img class="corr" src="assets/images/admin-icons/nothink.png" alt="">
                    <?php else: ?>
                        <img class="corr" src="assets/images/answers/correct.png" alt="">
                    <?php endif; ?>
                    <a href="?page=addHomework&Lessonid=<?= $lesson['id'] ?>">
                        <img src="assets/images/admin-icons/edit.png" alt="">
                    </a>
                </div>
            </div>

            <div class="lesson-update-btn">
                <p> Файлы урока:</p>
                <input type="file" name="" id="lesson-file">
                <label for="lesson-file">Добавить файл</label>
            </div>


            <div class="lesson-update-btn">
                <p>Описание:</p>
                <div class="lesson-box">
                    <textarea name="about" id=""><?= $lesson['about'] ?></textarea>

                </div>
            </div>
            <div class="lesson-update-btn">
                <p>Даты:</p>
                <div class="lesson-box">
                    <input type="date" name="dateFrom" value="<?= $lesson['dateFrom'] ?>">
                    <input type="date" name="dateTo" value="<?= $lesson['dateTo'] ?>">
                </div>
            </div>
            <input type="submit">
        </form>


    </div>

</div>
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