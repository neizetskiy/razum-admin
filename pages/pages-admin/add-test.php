<?php if (isset($_GET['lessonId'])) {
    $lesson = $database->query("SELECT * FROM `lessons` WHERE `id` = " . $_GET['lessonId'])->fetch(2);
    $course = $database->query("SELECT * FROM `courses` WHERE `id` = " . $lesson['courseId'])->fetch(2);


} ?>
<form class="check-top" method="POST" action="actions/addquestion.php?Lessonid=<?= $lesson['id'] ?>">
    <p class="url">Курсы /
        <?= $course['id'] ?> /
        <?= $course['name'] ?> /
        <?= $lesson['name'] ?> / Домашнее задание / Добавление задания
    </p>
    <div class="homework-add">
        <div class="check-grid-header">
            <h3>ЗАДАНИЕ</h3>
            <textarea name="question" id="" cols="30" rows="10"></textarea>

        </div>
        <div class="check-grid">
            <p>Баллы</p>
            <div class="add-input">
                <input type="text" name="balls" value="1">
            </div>
        </div>
        <div class="check-grid">
            <p>тип ответа</p>
            <div class="add-input">
                <select name="type" id="typeofquest">
                    <option value="test">Тест</option>
                    <option value="string">Строка</option>
                    <option value="free">Свободный</option>
                </select>
            </div>
        </div>
    </div>

    <div class="test" id="test">
        <p class="url">Варианты ответов</p>
        <div class="homework-add">
            <div class="test-grid">
                <h3>№</h3>
                <h3>ОТВЕТ</h3>
                <h3>ПРАВИЛЬНЫЙ</h3>
                <h3>ДЕЙСТВИЯ</h3>
            </div>

            <div class="test-grid">
                <div class="test-grid-value">
                    <p class="circle">1</p>
                </div>
                <div class="test-grid-value">
                    <div class="add-input">
                        <input name="value[]" type="text" value="">
                    </div>
                </div>
                <div class="test-grid-value">
                    <div class="add-input">
                        <input type="checkbox" name="checkbox[]" value="1">
                    </div>
                </div>
                <div class="test-grid-value">
                    <a href="">
                        <img src="assets/images/admin-icons/XSquare.png" alt="">
                    </a>
                </div>
            </div>

            

            <div class="test-add-value">
                <input type="button" id="add" class="go-to" value="+ Добавить вариант">
            </div>

        </div>
    </div>

    <Script>
        const ad = document.getElementById('add');
        let sum = 1;
        ad.addEventListener('click', function () {
            sum += 1;
            const newHTML = `<div class="test-grid">
                <div class="test-grid-value">
                    <p class="circle">${sum}</p>
                </div>
                <div class="test-grid-value">
                    <div class="add-input">
                        <input name="value[]" type="text" value="">
                    </div>
                </div>
                <div class="test-grid-value">
                    <div class="add-input">
                        <input type="checkbox" name="checkbox[]" value="${sum}">
                    </div>
                </div>
                <div class="test-grid-value">
                    <a href="">
                        <img src="assets/images/admin-icons/XSquare.png" alt="">
                    </a>
                </div>
            </div>`;
            testG = document.querySelectorAll('.test-grid');
            for (let i = 0; i < testG.length; i++) {
                if(i == testG.length -1){
                    testG[i].insertAdjacentHTML('afterend', newHTML)
                }
            }
        })
    </Script>




    <div class="string hidden" id="string">
        <p class="url">Варианты ответов</p>
        <div class="homework-add">
            <div class="string-grid">
                <h3>№</h3>
                <h3>ОТВЕТ</h3>
                <h3>ДЕЙСТВИЯ</h3>
            </div>
            <div class="string-grid">
                <div class="string-grid-value">
                    <p class="circle">1</p>
                </div>
                <div class="string-grid-value">
                    <div class="add-input">
                        <input type="text" name="valueString" value="">
                    </div>
                </div>

                <div class="string-grid-value">
                    <a href="">
                        <img src="assets/images/admin-icons/XSquare.png" alt="">
                    </a>
                </div>
            </div>

        </div>
    </div>

    <input type="submit">
</form>

<script>
    let sale = document.getElementById('typeofquest');
    sale.addEventListener('change', function () {
        if (sale.value == 'test') {
            document.getElementById('test').classList.remove('hidden');
            document.getElementById('string').classList.add('hidden');
        }
        if (sale.value == 'string') {
            document.getElementById('string').classList.remove('hidden');
            document.getElementById('test').classList.add('hidden');
        }
        if (sale.value == 'free') {
            document.getElementById('test').classList.add('hidden');
            document.getElementById('string').classList.add('hidden');
        }
    })
</script>