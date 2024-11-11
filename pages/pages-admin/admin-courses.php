<?php
if (!isRole()) {
    die();
}

$orderBy = '';
$sortColumns = [
    'nameUp' => 'name',
    'nameDown' => 'name DESC',
    'idUp' => 'id',
    'idDown' => 'id DESC',
    'teacherUp' => 'teacher',
    'teacherDown' => 'teacher DESC',
    'curatorUp' => 'curator',
    'curatorDown' => 'curator DESC',
    'countUp' => 'peoples',
    'countDown' => 'peoples DESC'
];
if (isset($_GET['sort']) && isset($sortColumns[$_GET['sort']])) {
    $orderBy = "ORDER BY {$sortColumns[$_GET['sort']]}";
}

$searchQueries = [];
if (isset($_GET['id'])) {
    $searchQueries[] = "`id` LIKE '%" . $_GET['id'] . "%'";
}
if (isset($_GET['name'])) {
    $searchQueries[] = "`name` LIKE '%" . $_GET['name'] . "%'";
}
if (isset($_GET['teacher'])) {
    $searchQueries[] = "`teacher` LIKE '%" . $_GET['teacher'] . "%'";
}
if (isset($_GET['curator'])) {
    $searchQueries[] = "`curator` LIKE '%" . $_GET['curator'] . "%'";
}


$where = '';
if (!empty($searchQueries)) {
    $where = "WHERE " . implode(" AND ", $searchQueries);
}


if(isset($_GET['count'])){
    $purchased = $database->query("SELECT courseId, COUNT(*) AS count FROM Purchased GROUP BY courseId; ")->fetchAll(2);
    foreach ($purchased as $pr) {
        if($pr['count'] == $_GET['count']){
            $courses = $database->query("SELECT * FROM `courses` WHERE `id` = " . $pr['courseId'])->fetchAll(2);
        }   
    }
}
else{
    $courses = $database->query("SELECT * FROM `courses` $where $orderBy")->fetchAll(2);
}
?>


<script src="assets/js/addCourse.js" defer></script>
<script src="assets/js/validation.js" defer></script>
<div class="add-course-bg" id="form">
    <form action="" id="courses" method="POST" class="add-course">
        <h2>ДОБАВИТЬ КУРС</h2>
        <input type="text" name="name" placeholder="Название курса">
        <select name="deadline" id="">
            <option value="off">Без дедлайна</option>
            <option value="on">С дедлайном</option>
        </select>
        <input type="submit" value="создать">
        <label id="erroraddCourses" class="label">

        </label>
        <div class="krest" id="krest">
            ✕
        </div>
    </form>
</div>

<div class="container">
    <div class="profile">
        <h1>Курсы</h1>
        <div class="users">
            <div class="admin-courses-header">

                <div class="fortableheader">
                    <form action="" method="get">
                        <input type="hidden" value="adminCourses" name="page">
                        <input class="search" type="search" name="id" placeholder="ID">
                        <input class="hidden" type="submit">
                    </form>

                    <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'idUp') {
                        echo '?page=adminCourses&sort=idDown';
                    } else {
                        echo '?page=adminCourses&sort=idUp';
                    } ?> ">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>

                <div class="fortableheader">
                    <form action="" method="get">
                        <input type="hidden" value="adminCourses" name="page">
                        <input class="search" type="search" name="name" placeholder="Название">
                        <input class="hidden" type="submit">
                    </form>

                    <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'nameUp') {
                        echo '?page=adminCourses&sort=nameDown';
                    } else {
                        echo '?page=adminCourses&sort=nameUp';
                    } ?>">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <form action="" method="get">
                        <input type="hidden" value="adminCourses" name="page">
                        <input class="search" type="search" name="teacher" placeholder="Преподаватель">
                        <input class="hidden" type="submit">
                    </form>

                    <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'teacherUp') {
                        echo '?page=adminCourses&sort=teacherDown';
                    } else {
                        echo '?page=adminCourses&sort=teacherUp';
                    } ?>">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <form action="" method="get">
                        <input type="hidden" value="adminCourses" name="page">
                        <input class="search" type="search" name="curator" placeholder="Куратор">
                        <input class="hidden" type="submit">
                    </form>

                    <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'curatorUp') {
                        echo '?page=adminCourses&sort=curatorDown';
                    } else {
                        echo '?page=adminCourses&sort=curatorUp';
                    } ?>">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <form action="" method="get">
                        <input type="hidden" value="adminCourses" name="page">
                        <input class="search" type="search" name="count" placeholder="Количество учеников">
                        <input class="hidden" type="submit">
                    </form>

                    <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'countUp') {
                        echo '?page=adminCourses&sort=countDown';
                    } else {
                        echo '?page=adminCourses&sort=countUp';
                    } ?>">
                        <img src="assets/images/admin-icons/arrows.png" alt="">
                    </a>
                </div>
                <div class="fortableheader">
                    <a class="user-header-flex" href="">
                        <p>ДЕЙСТВИЯ</p>
                    </a>
                </div>
            </div>
            <?php if (isset($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <?php
                    if ($course['curator'] === null) {
                        $curator = [
                            'name' => '',
                            'surname' => ''
                        ];
                    } else {
                        $curator = $database->query("SELECT * FROM `users` WHERE `id` = " . $course['curator'])->fetch(2);
                    }

                    if ($course['teacher'] === null) {
                        $teacher = [
                            'image' => '',
                            'name' => '',
                            'surname' => ''
                        ];
                    } else {
                        $teacher = $database->query("SELECT * FROM `users` WHERE `id` = " . $course['teacher'])->fetch(2);
                    }
                    ?>
                    <div class="users-date">
                        <div class="admin-courses-grid">
                            <div class="user-item">
                                <p class="id">
                                    <?= $course['id'] ?>
                                </p>
                            </div>
                            <div class="user-item">
                                <a href="?page=updateCourse&id=<?= $course['id'] ?>">
                                    <p><?= $course['name'] ?></p>
                                </a>
                            </div>
                            <div class="user-item">
                                <img src="<?= $teacher['image'] ?>" alt="">
                                <div class="user-name">
                                    <p>
                                        <?= $teacher['surname'] ?>
                                        <?= $teacher['name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="user-item kur-s">

                                <div class="kur">
                                    <div class="num-admin">1</div>
                                    <p>
                                        <?= $curator['surname'] ?>
                                        <?= $curator['name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="user-item">
                                <p>
                                    <?php
                                    $puch = $database->query("SELECT * FROM `Purchased` WHERE `courseId` = " . $course['id'])->fetchAll(2);
                                    echo count($puch);
                                    ?>
                                </p>
                            </div>

                            <div class="user-item">
                                <?php if (count($puch) == 0): ?>
                                    <a onclick="return confirm('Вы уверены что хотите удалить курс?')"
                                        href="/actions/deleteCourse.php?id=<?= $course['id'] ?>"><img
                                            src="assets/images/admin-icons/XSquare.png" alt=""></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="users-date">
                <p class="go-to" id="addcourse">+ Создать курс</p>
            </div>
        </div>
    </div>

</div>