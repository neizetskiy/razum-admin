<script src="assets/js/validation.js" defer></script>
<?php
$user = $database->query("SELECT *, roles.name AS Role_Name, users.name AS User_Name FROM `users` JOIN `roles` ON users.role = roles.id WHERE users.id = " . $_GET['id'])->fetch(2);
// $Purchased = $database->query("SELECT * FROM `Purchased` JOIN `courses` ON Purchased.courseId = courses.id WHERE `userId` = " . $_GET['id'])->fetchAll(2);
$Purchased = $database->query("SELECT * FROM `Purchased` JOIN `courses` ON Purchased.courseId = courses.id WHERE `userId` = " . $_GET['id'])->fetchAll(2);

// $Purchased = $database->query("SELECT * FROM `Purchased` LEFT JOIN `courses` ON Purchased.courseId = courses.id WHERE `userId` = " . $_GET['id'])->fetchAll(2);

if (!isRole()) {
    die();
}
?>
<div class="container">

    <div class="admin-user-profile">
        <p>Пользователи /
            <?= $user['surname'] ?>
            <?= $user['User_Name'] ?>
        </p>
        <div class="admin-user-profile-info">
            <div class="admin-user-profile-about">
                <div class="admin-user-prodile-img">
                    <img src="<?= $user['image'] ?>" alt="">
                    <div class="admin-user-name">
                        <p>
                            <?= $user['surname'] ?>
                            <?= $user['User_Name'] ?>
                        </p>
                        <span class="gray">
                            <?= $user['Role_Name'] ?>
                        </span>
                    </div>
                </div>
                <div class="admin-user-info">
                    <h4>Информация</h4>
                    <p>Номер телефона: <span>
                            <?= $user['phone'] ?>
                        </span></p>
                    <p>Дата регистрации: <span>
                            <?= $user['date_create'] ?>
                        </span></p>
                    <p>ID: <span>
                            <?= $user['id'] ?>
                        </span></p>

                    <?php if(isRole()=='admin'): ?>
                    <p id="openRole" class="go-to">Добавить роль</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="admin-user-profile-right">
                <div class="financ">
                    <h4>Финансовые операции</h4>
                    <div class="financ-header">
                        <p>Стоимость</p>
                        <p>Дата и время</p>
                        <p>Название курса</p>
                    </div>

                    <?php foreach ($Purchased as $item): ?>
                        <div class="financ-grid">
                            <span>
                                <?= $item['price'] ?> ₽
                            </span>
                            <p>
                                <?= $item['date_buy'] ?>
                            </p>
                            <div class="nameofcourse">
                                <div class="num-admin">
                                    <?= $item['id'] ?>
                                </div>
                                <p>
                                    <?= $item['name'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>



                <?php
                $user = $database->query("SELECT *, roles.name AS Role_Name, users.name AS User_Name FROM `users` JOIN `roles` ON users.role = roles.id WHERE users.id = " . $_GET['id'])->fetch(2);
                $Purchased = $database->query("SELECT * FROM `Purchased` JOIN `courses` ON Purchased.courseId = courses.id WHERE `userId` = " . $_GET['id'])->fetchAll(2);

                if (!isRole()) {
                    die();
                }
                ?>

                <div class="admin-user-profile-courses">
                    <p>Активные курсы</p>
                    <?php if(!$Purchased): ?>
                        <p class="NoLearning">Активных курсов нет</p>
                    <?php endif; ?>
                    <div class="admin-user-profile-courses-items">
                        <?php foreach ($Purchased as $pur): ?>
                            <?php
                            $lessons = $database->query("SELECT DISTINCT lessons.id, lessons.name FROM `lessons` JOIN `homeworks` ON lessons.id = homeworks.lessonId WHERE `courseId` = " . $pur['courseId'])->fetchAll(2);

                            // Подсчет общего количества уроков
                            $totalLessons = count($lessons);

                            // Подсчет количества уроков с решенными заданиями (независимо от статуса проверки)
                            $completedLessons = 0;
                            // Подсчет количества уроков с проверенными заданиями
                            $checkedLessons = 0;
                            foreach ($lessons as $lesson) {
                                $lessonId = $lesson['id'];
                                $statusQuery = $database->query("SELECT status FROM `peoplesanswers` WHERE `question_id` IN (SELECT questionid FROM `homeworks` WHERE `lessonId` = $lessonId) AND `user_id` = " . $_GET['id'])->fetch();

                                if (isset($statusQuery['status'])) {
                                    $completedLessons++;
                                    if ($statusQuery['status'] == 'checked') {
                                        $checkedLessons++;
                                    }
                                }
                            }

                            // Вычисление процента выполненных уроков
                            $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

                            // Проверка, все ли задания курса проверены
                            $showCertificateButton = ($checkedLessons == $totalLessons);
                            ?>
                            <div class="admin-user-profile-courses-name">
                                <div class="admin-user-profile-courses-left">
                                    <p class="num-courses"><?= $pur['courseId']; ?></p>
                                    <span><?= $pur['name']; ?></span>
                                </div>
                                <?php if(isRole() == 'admin'): ?>
                                    <img src="assets/images/admin-icons/XSquare.png" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="flex-column">
                                <p>Прогресс по курсу (<?= $progressPercentage ?>%)</p>
                                <?php if ($showCertificateButton): ?>
                                    <a href="download_certificate.php?courseId=<?= $pur['courseId'] ?>" class="download-certificate">Скачать сертификат <img src="assets/images/admin-icons/courses.svg" alt=""></a>
                                <?php else: ?>
                                    <p class="download-certificate">Сертификат недоступен (курс незавершён)</p>
                                <?php endif; ?>
                                <div class="progress-bar">
                                    <?php foreach ($lessons as $lesson): ?>
                                        <?php
                                        $lessonId = $lesson['id'];
                                        $statusQuery = $database->query("SELECT status FROM `peoplesanswers` WHERE `question_id` IN (SELECT questionid FROM `homeworks` WHERE `lessonId` = $lessonId) AND `user_id` = " . $_GET['id'])->fetch();

                                        if (isset($statusQuery['status']) && $statusQuery['status'] == 'on_check') {
                                            $statusClass = 'yellow-bar';
                                        } elseif (isset($statusQuery['status']) && $statusQuery['status'] == 'checked') {
                                            $statusClass = 'green-bar';
                                        } else {
                                            $statusClass = 'gray-bar';
                                        }
                                        ?>
                                        <div class="section <?= $statusClass ?>"></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal" class="modalRole hidden">
        <form id="modalRole" method="POST" action="">
            <?php 
            $roles = $database->query("SELECT * FROM `roles`")->fetchAll(2);
            ?>
            <input type="hidden" value="<?= $_GET['id'] ?>" name="userid">
            <select name="newRole" id="">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>">
                        <?= $role['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Выдать">
            <p id="close" class="close">X</p>
        </form>
    </div>
</div>
</div>

<script> 

let openRole =document.getElementById('openRole');
let close =document.getElementById('close');
openRole.addEventListener('click', function(){
    let modal =document.getElementById('modal');
    modal.classList.toggle('hidden');
})
close.addEventListener('click', function(){
    let modal =document.getElementById('modal');
    modal.classList.toggle('hidden');
})

</script>
