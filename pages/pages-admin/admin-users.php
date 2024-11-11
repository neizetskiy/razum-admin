<?php
// Обработка сортировки
$sort = $_GET['sort'] ?? 'dateDown';
$order = ($sort === 'nameDown') ? 'DESC' : 'ASC';
$dateOrder = ($sort === 'dateDown') ? 'DESC' : 'ASC';

$orderBy = '';
if ($sort) {
    if ($sort === 'nameUp' || $sort === 'nameDown') {
        $orderBy = "ORDER BY users.name $order, users.date_create $dateOrder";
    } elseif ($sort === 'dateUp' || $sort === 'dateDown') {
        $orderBy = "ORDER BY users.date_create $dateOrder, users.name $order";
    }
} else {
    $orderBy = "ORDER BY users.date_create DESC"; // Сортировка от нового к старому
}

// Обработка поиска
$searchField = $_GET['name'] ?? $_GET['phone'] ?? null;
$searchType = isset($_GET['name']) ? 'name' : 'phone';
$searchQuery = ($searchField) ? "WHERE users.$searchType LIKE ?" : '';

// Пагинация
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$perPage = 5;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

// Подготовка запроса и выполнение
$stmt = $database->prepare("
    SELECT *, roles.name AS Role_Name, users.name AS User_Name, users.id AS User_ID
    FROM users
    JOIN roles ON users.role = roles.id
    $searchQuery
    $orderBy
    LIMIT ?, ?
");

if ($searchField) {
    $search_value = "%$searchField%";
    $stmt->bindParam(1, $search_value, PDO::PARAM_STR);
    $stmt->bindValue(2, $start, PDO::PARAM_INT);
    $stmt->bindValue(3, $perPage, PDO::PARAM_INT);
} else {
    $stmt->bindValue(1, $start, PDO::PARAM_INT);
    $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
}

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Общее количество пользователей для пагинации
$totalUsers = $database->query("SELECT COUNT(*) as total FROM users")->fetch(PDO::FETCH_ASSOC)['total'];
$pages = ceil($totalUsers / $perPage);
$maxPages = 10;

// Вычисляем начало и конец диапазона страниц
$startPage = max(1, $page - floor($maxPages / 2));
$endPage = min($startPage + $maxPages - 1, $pages);

if (!isRole()) {
    die();
}
?>

<div class="container">
    <h1>Пользователи</h1>
    <div class="users">

        <div class="users-header">
            <div class="user-flex">
                <form action="" method="get">
                    <input type="hidden" value="adminUsers" name="page">
                    <input class="search" type="search" name="name" placeholder="Поиск по имени">
                    <input class="hidden" type="submit">
                </form>

                <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'nameUp') {
                    echo '?page=adminUsers&sort=nameDown';
                } else {
                    echo '?page=adminUsers&sort=nameUp';
                } ?>">

                    <img src="assets/images/admin-icons/arrows.png" alt="">
                </a>

            </div>
            <div class="user-flex">
                <select name="" id="">
                    <option value="">Администратор</option>
                    <option value="">Пользователь</option>
                    <option value="">Куратор</option>
                </select>
                <a class="user-header-flex" href="">

                    <img src="assets/images/admin-icons/arrows.png" alt="">
                </a>

            </div>
            <div class="user-flex">
                
                <form action="" method="get">
                    <input type="hidden" value="adminUsers" name="page">
                    <input class="search" type="search" name="phone" placeholder="Поиск по номеру">
                    <input class="hidden" type="submit">
                </form>

                <a class="user-header-flex" href="">
                    <img src="assets/images/admin-icons/arrows.png" alt="">
                </a>
            </div>

            <div class="user-flex">
                <input class="search" type="date" placeholder="Поиск по имени">
                <p>до</p>
                <input class="search" type="date" placeholder="Поиск по имени">
                <a class="user-header-flex" href="<?php if (isset($_GET['sort']) && $_GET['sort'] == 'dateUp') {
            echo '?page=adminUsers&sort=dateDown';
        } else {
            echo '?page=adminUsers&sort=dateUp';
        } ?>">
                    <img src="assets/images/admin-icons/arrows.png" alt="">
                </a>
            </div>

        </div>
        <?php foreach ($users as $user): ?>
            <div class="users-date">
                <div class="user-grid">
                    <div class="user-item">
                        <img src="<?= $user['image'] ?>" alt="">
                        <div class="user-name">
                            <a href="?page=adminuserprofile&id=<?= $user['User_ID'] ?>">
                                <?= $user['surname'] ?>
                                <?= $user['User_Name'] ?>
                            </a>
                        </div>
                    </div>
                    <div class="user-item">
                        <p>
                            <?= $user['Role_Name'] ?>
                        </p>
                    </div>
                    <div class="user-item">
                        <p>
                            <?= $user['phone'] ?>
                        </p>
                    </div>
                    <div class="user-item">
                        <p>
                            <?= $user['date_create'] ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a class='pagin prev' href='?page=adminUsers&p=" . ($page - 1) . "'><svg width='8' height='13' viewBox='0 0 8 13' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path d='M1.2002 11.48L6.20019 6.47998L1.20019 1.47998' stroke='#7A7A7A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></a> ";
            }
            ?>
            <div class="pag-num">
                <?php
                // Выводим ссылки на страницы
                for ($i = $startPage; $i <= $endPage; $i++) {
                    if (isset($_GET['p']) && $_GET['p'] == $i) {
                        echo "<a class='pagin active' href='?page=adminUsers&p=$i'>$i</a> ";
                    } else {
                        echo "<a class='pagin' href='?page=adminUsers&p=$i'>$i</a> ";
                    }

                }
                ?>
            </div>
            <?php
            // Выводим ссылку на следующую страницу
            if ($page < $pages) {
                echo "<a class='pagin next' href='?page=adminUsers&p=" . ($page + 1) . "'> <svg width='8' height='13' viewBox='0 0 8 13' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path d='M1.2002 11.48L6.20019 6.47998L1.20019 1.47998' stroke='#7A7A7A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                </svg>
                
                </a>";
            }
            ?>
        </div>
    </div>

</div>