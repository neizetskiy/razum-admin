<?php
$user = $database->query("SELECT * FROM `users` WHERE `id` = " . $_GET['uid'])->fetch(2);
$Lid = $_GET['Lid'];
$userid = $_GET['uid'];
$homeworks = $database->query("SELECT * FROM `homeworks` WHERE `lessonId` = '$Lid'")->fetchAll(2);





$peopleanswer = $database->query("SELECT * FROM `peoplesanswers` WHERE  `user_id` = " . $user['id'])->fetch(2);
$lesson = $database->query("SELECT * FROM `lessons` WHERE `id` = '$Lid'")->fetch(2);
$course = $database->query("SELECT * FROM `courses` WHERE `id` = " . $lesson['courseId'])->fetch(2);

$status = $peopleanswer['status'];
if ($status == 'on_check') {
    $class = 'process';
    $text = 'На проверке';
} else if ($status == 'checked') {
    $class = 'okay';
    $text = 'Проверено';
} else {
    $class = 'gray';
    $text = 'Выдано';
}

?>

<div class="check-homework-info">

    <div class="check-homework">
        <div class="check-top">
            <p class="url">Задания /
                <?= $peopleanswer['id'] ?> / Домашнее задание
            </p>
            <div class="homework-check-info">
                <div class="check-grid">
                    <h3>ID</h3>
                    <h3>
                        <?= $peopleanswer['id'] ?>
                    </h3>
                </div>
                <div class="check-grid">
                    <p>Пользователь</p>
                    <p>
                        <?= $user['id'] ?> -
                        <?= $user['surname'] ?>
                        <?= $user['name'] ?>
                    </p>
                </div>
                <div class="check-grid">
                    <p>Курс</p>
                    <p>
                        <?= $course['id'] ?> -
                        <?= $course['name'] ?>
                    </p>
                </div>
                <div class="check-grid">
                    <p>Урок</p>
                    <p>
                        <?= $lesson['name'] ?>
                    </p>
                </div>
                <div class="check-grid">
                    <p>Статус</p>
                    <p>
                        <span class="<?= $class ?>">
                            <?= $text ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="check-top">
            <p class="url">История статусов</p>
            <div class="homework-check-info">
                <div class="check-grid">
                    <h3>СТАТУС</h3>
                    <h3>ДАТА</h3>
                </div>
                <div class="check-grid">
                    <p> <span class="green">Выдано</span></p>
                    <p>08.11.2023 17:22</p>
                </div>
                <div class="check-grid">
                    <p><span class="yellow">На проверке</span></p>
                    <p>08.11.2023 18:03</p>
                </div>

            </div>
        </div>
    </div>



    <form method="POST" action="../actions/sendCheck.php" class="check-top">
        <p class="url">Ответы</p>
        <div class="homework-check-info">
            <div class="check-answers-header">
                <h3>№</h3>
                <h3>ЗАДАНИЕ</h3>
                <h3>ТИП ОТВЕТ</h3>
                <h3>ПРАВИЛЬНЫЙ ОТВЕТ</h3>
                <h3>ОТВЕТ ПОЛЬЗОВАТЕЛЯ</h3>
                <h3>БАЛЛЫ</h3>
            </div>
            <?php
            $sum = 0;
            foreach ($homeworks as $key):
                $sum += 1 ;
                $question = $database->query("SELECT * FROM `questions` WHERE `id` = " . $key['questionid'])->fetch(2);
                $rightanswer = $database->query("SELECT * FROM `rightanswers` WHERE `rightA` = 1 AND `question_id` = " . $question['id'])->fetch(2);
                if ($question['type'] == 'test') {
                    $ansid = $database->query("SELECT * FROM `peoplesanswers` WHERE `user_id` = '$userid'  AND `question_id` = " . $question['id'])->fetch(2);
                    $userAnswer = $database->query("SELECT name FROM `rightanswers` WHERE `id` = " . $ansid['answer'])->fetch(2);
                } else {
                    $userAnswer = $database->query("SELECT * FROM `peoplesanswers` WHERE `user_id` = '$userid'  AND `question_id` = " . $question['id'])->fetch(2);
                }

                ?>
                <div class="check-answers">
                    <div class="circle"><?= $sum ?></div>
                    <p>
                        <?= $question['question'] ?>
                    </p>
                    <p>
                        <?= $question['type'] ?>
                    </p>
                    <p>
                        <?php if ($rightanswer) {
                            echo $rightanswer['name'];
                        } else{
                            echo '-';
                        } ?>
                    </p>
                    <p class="check-text w267 <?php if ($question['type'] == 'test') {
                        if ($rightanswer['name'] == $userAnswer['name']) {
                            echo 'greenBG';
                        } else {
                            echo 'redBG';
                        }
                    } else {
                        if ($rightanswer['name'] == $userAnswer['answer']) {
                            echo 'greenBG';
                        } else {
                            echo 'redBG';
                        }
                    } ?>">
                        <?php echo $question['type'] == 'test' ? $userAnswer['name'] : $userAnswer['answer']; ?>
                    </p>
                    <div class="blue"><input name="ball[]" class="balls" type="text" >/
                        <?= $question['balls'] ?>
                    </div>
                    <input type="hidden" name="qid[]" value="<?= $question['id'] ?>">
                </div>
            <?php endforeach; ?>
                    <input type="hidden" name="userid" value="<?= $userid; ?>">
        </div>
        <div class="comment">
            <p class="go-to">Комментарий</p>
            <input name="comment" type="text">
        </div>
        <input class="go-to" type="submit">
    </form>
</div>