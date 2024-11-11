<?php
if (isset($_GET['Lessonid'])) {
    $homework = $database->query("SELECT * FROM `homeworks` JOIN `questions` ON homeworks.questionid = questions.id WHERE `lessonId` = " . $_GET['Lessonid'])->fetchAll(2);
}
?>
<div class="update-course">
    <div class="add-lesson">
        <p class="url">Курсы / 32 / Лечение ОКР / Урок 1 - Введение / Домашнее задание</p>
        <div class="add-lesson-table">
            <div class="add-lesson-header">
                <h3>№</h3>
                <h3>ЗАДАНИЕ</h3>
                <h3>ТИП ОТВЕТА</h3>
                <h3>БАЛЛЫ</h3>
                <h3>ДЕЙСТВИЯ</h3>
            </div>
            <?php
            $ball = 0;
            $sum = 0;
                ?>
            <?php foreach ($homework as $quest): ?>
                <?php $sum += 1 ?>
                <div class="add-lesson-body">
                    <p class="circle"><?= $sum ?></p>
                    <p class="add-lesson-text"><?= $quest['question'] ?> </p>
                    <p><?php if($quest['type'] == 'string'){ echo 'Строка'; } elseif($quest['type'] == 'test') { echo 'Тест'; } else{ echo 'Свободный';}?></p>
                    <p class="blue"><?= $quest['balls'] ?></p>
                    <?php 
                    $ball += $quest['balls'];
                    ?>
                    <div class="actions">
                        <img src="assets/images/admin-icons/XSquare.png" alt="">
                        <img src="assets/images/admin-icons/edit.png" alt="">
                    </div>
                </div>
            <?php endforeach; ?>


            <div class="add-lesson-footer">
                <a href="?page=addtest&lessonId=<?= $_GET['Lessonid'] ?>" class="go-to">+ Добавить задание</a>
                <div class="add-lesson-footer-end">
                    <img src="assets/images/answers/spellcheck.png" alt="">
                    <p>Итого баллов:</p>
                    <span><?= $ball ?></span>
                </div>
            </div>
        </div>

    </div>
</div>