<?php
$courses = $database->query("SELECT * FROM `courses` ")->fetchAll(2);
$quests = $database->query("SELECT *, courses.id AS CourseId FROM `Purchased` JOIN `courses` ON Purchased.courseId = courses.id")->fetchAll(2);

if (!isRole()) {
    die();
}
?>
<script src="assets/js/validation.js" defer></script>
<div class="container">
    <div class="profile adminExercise">
        <h1>Задания</h1>
        <div class="users">
            <div class="exercise">

                <div class="fortableheader">
                    <input class="search" type="search" placeholder="ID">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>


                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Пользователь">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Курс">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Урок">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <input class="search" type="search" placeholder="Дедлайн">
                    <a class="user-header-flex" href="">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <select name="" id="">
                        <option value="">Выполнено</option>
                        <option value="">Выдано</option>
                    </select>
                    <a class="user-header-flex" href="">
                    </a>
                </div>
            </div>
            <?php $sum = 0 ?>
            <?php foreach ($quests as $two): ?>
                <?php
                $lessons = $database->query("SELECT * FROM `lessons` WHERE `courseId` = " . $two['CourseId'])->fetchAll(2);
                $users = $database->query("SELECT * FROM `users` WHERE `id` = " . $two['userId'])->fetch(2);
                 
                ?>
                <?php foreach ($lessons as $one): ?>
                    
                    <?php $sum += 1; ?>
                    <?php
                    $course = $database->query("SELECT * FROM `courses` WHERE `id` = " . $one['courseId'])->fetch(2);

                    // Проверка статуса задания для данного урока
                    $lessonId = $one['id'];
                    $questionId = $database->query("SELECT questionId FROM `homeworks` WHERE `lessonId` = $lessonId")->fetchColumn();
                    $userId = $two['userId'];
                    $statusQuery = $database->query("SELECT `status` FROM `peoplesanswers` WHERE `question_id` = '$questionId' AND `user_id` = '$userId'")->fetchColumn();
                    $statusid = $database->query("SELECT * FROM `peoplesanswers` WHERE `user_id` = " . $userId)->fetch(2);
                    // Определение класса в зависимости от статуса
                    if($statusQuery == 'on_check'){
                        $class = 'process';
                    }
                    else if($statusQuery == 'checked'){
                        $class = 'okay';
                    }
                    else{
                        $class = 'gray';
                    }
                    ?>

                    <div class="users-date">
                        <div class="exercise">
                            <div class="user-item">
                                <a href="?page=check&id=<?= $one['id'] ?>&Lid=<?= $one['id'] ?>&uid=<?= $userId ?>" class="id">
                                    <?= $statusid['id'] ?>-<?= $questionId ?>
                                </a>
                            </div>
                            <div class="user-item">
                                <img src="<?= $users['image'] ?>" alt="">
                                <div class="user-name">
                                    <p>
                                        <?= $users['surname'] ?>
                                        <?= $users['name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="user-item kur-s">
                                <div class="kur">
                                    <div class="num-admin">1</div>
                                    <p>
                                        <?= $course['name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="user-item">
                                <p>
                                    <?= $one['name'] ?>
                                </p>
                            </div>
                            <div class="user-item">
                                <p>
                                    <?php if ($one['dateTo'] != null)
                                        echo $one['dateTo']; ?>
                                </p>
                            </div>
                            <div class="user-item">
                                <p class="<?= $class ?>"><?php if($class == 'gray'): ?>Выдано <?php elseif($class == 'okay'): ?> Проверено <?php else: ?> На проверке <?php endif; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>



            <div class="add-course-bg" id="form">
                <form action="" id="lessons" method="POST" class="add-course">
                    <h2>ДОБАВИТЬ УРОК</h2>
                    <input type="text" name="name" placeholder="Название урока">
                    <select name="courseId" id="">
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>">
                                <?= $course['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="создать">
                    <label id="erroraddLessons" class="label">

                    </label>
                    <div class="krest" id="krest">
                        ✕
                    </div>
                </form>
            </div>

            <div class="users-date">
                <p class="go-to" id="addlesson">+ Добавить задание</p>
            </div>

        </div>
    </div>

</div>

<script>
    let btn = document.getElementById('addlesson')
    let krest = document.getElementById('krest')
    let form = document.getElementById('form')
    btn.addEventListener('click', function () {
        form.style.display = 'flex';
    })
    krest.addEventListener('click', function () {
        form.style.display = 'none';
    })
</script>