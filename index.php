<?php
// ini_set('post_max_size', '3008M'); // Устанавливаем максимальный размер данных POST-запроса
// ini_set('upload_max_filesize', '3008M');
session_start();
require('connect/connect.php');
require('actions/functions.php');
if (isset($_SESSION['uid'])) {
    $user = $database->query("SELECT * FROM `users` WHERE `id` = " . $_SESSION['uid'])->fetch(2);
    $Purchased = $database->query("SELECT * FROM `Purchased` WHERE `userId` =" . $_SESSION['uid'])->fetchAll(2);
}


?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/burder.js" defer></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <title>Разумнейро |
        <?php if (isset($_GET['page']))
            echo $_GET['page'] ?>
        </title>
    </head>

    <body>
       
        <?php if (isset($_GET['page']) && ($_GET['page'] != 'reg' && $_GET['page'] != 'auth' && $_GET['page'] != 'etap')): ?>
            <header>
                <a href="<?php if (isRole()): ?>?page=adminUsers<?php else: ?>?page=profile<?php endif; ?>">
                    <img class="logo-header" src="assets/images/logo/logo.png" alt="">
                </a>

                <div class="lunge" id="lunge">
                    <div class="lunge-info">
                        <img class="profile-img" src="<?= $user['image'] ?>" alt="">
                        <div class="lunge-info-name">
                            <p>
                                <?= $user['name'] ?>
                                <?= $user['surname'] ?>
                            </p>
                            <span>
                                <?= isRole(); ?>
                            </span>
                        </div>
                    </div>
                    <a href="?page=profile" class="lunge-action">
                        <svg width="20px" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.625 0.560059C5.19531 0.560059 4.79004 0.643066 4.40918 0.809082C4.02832 0.975098 3.69629 1.19971 3.41309 1.48291C3.12988 1.76611 2.90527 2.09814 2.73926 2.479C2.58301 2.8501 2.50488 3.25537 2.50488 3.69482C2.50488 4.12451 2.58301 4.52979 2.73926 4.91064C2.90527 5.2915 3.12988 5.62109 3.41309 5.89941C3.69629 6.17773 4.02832 6.3999 4.40918 6.56592C4.79004 6.73193 5.19531 6.81494 5.625 6.81494C6.05469 6.81494 6.45996 6.73193 6.84082 6.56592C7.22168 6.3999 7.55371 6.17773 7.83691 5.89941C8.12012 5.62109 8.34473 5.2915 8.51074 4.91064C8.66699 4.52979 8.74512 4.12451 8.74512 3.69482C8.74512 3.25537 8.66699 2.8501 8.51074 2.479C8.34473 2.09814 8.12012 1.76611 7.83691 1.48291C7.55371 1.19971 7.22168 0.975098 6.84082 0.809082C6.45996 0.643066 6.05469 0.560059 5.625 0.560059ZM5.625 5.56982C5.10742 5.56982 4.66553 5.38672 4.29932 5.02051C3.93311 4.6543 3.75 4.2124 3.75 3.69482C3.75 3.17725 3.93311 2.73535 4.29932 2.36914C4.66553 2.00293 5.10742 1.81982 5.625 1.81982C6.14258 1.81982 6.58447 2.00293 6.95068 2.36914C7.31689 2.73535 7.5 3.17725 7.5 3.69482C7.5 4.2124 7.31689 4.6543 6.95068 5.02051C6.58447 5.38672 6.14258 5.56982 5.625 5.56982ZM11.25 12.4399V11.8101C11.25 11.2046 11.1377 10.6382 10.9131 10.1108C10.6787 9.5835 10.3638 9.12207 9.96826 8.72656C9.57275 8.33105 9.11133 8.01611 8.58398 7.78174C8.04688 7.55713 7.47559 7.44482 6.87012 7.44482H4.37988C3.77441 7.44482 3.20312 7.55713 2.66602 7.78174C2.13867 8.01611 1.67725 8.33105 1.28174 8.72656C0.88623 9.12207 0.571289 9.5835 0.336914 10.1108C0.112305 10.6382 0 11.2046 0 11.8101V12.4399H1.24512V11.8101C1.24512 11.3804 1.32812 10.9751 1.49414 10.5942C1.66016 10.2134 1.88477 9.88379 2.16797 9.60547C2.45117 9.32715 2.7832 9.10498 3.16406 8.93896C3.53516 8.77295 3.94043 8.68994 4.37988 8.68994H6.87012C7.30957 8.68994 7.71484 8.77295 8.08594 8.93896C8.4668 9.10498 8.79883 9.32715 9.08203 9.60547C9.36523 9.88379 9.58984 10.2134 9.75586 10.5942C9.92188 10.9751 10.0049 11.3804 10.0049 11.8101V12.4399H11.25Z"
                                fill="#697A8D" />
                        </svg>
                        <p>Мой Профиль</p>
                    </a>
                    <a href="actions/exit.php" class="lunge-action">
                        <svg width="20px" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.52941 1.03795C6.52941 0.74085 6.29238 0.5 6 0.5C5.70761 0.5 5.47059 0.74085 5.47059 1.03795V3.90704C5.47059 4.20414 5.70761 4.44499 6 4.44499C6.29238 4.44499 6.52941 4.20414 6.52941 3.90704V1.03795Z"
                                fill="#697A8D" />
                            <path
                                d="M10.2426 2.0921C10.0359 1.88202 9.70068 1.88202 9.49394 2.0921C9.28719 2.30219 9.28719 2.6428 9.49394 2.85289C10.185 3.55507 10.6556 4.44971 10.8462 5.42367C11.0369 6.39762 10.939 7.40716 10.5651 8.32461C10.1911 9.24206 9.55774 10.0262 8.74517 10.5779C7.9326 11.1296 6.97727 11.4241 6 11.4241C5.02273 11.4241 4.06741 11.1296 3.25483 10.5779C2.44226 10.0262 1.80894 9.24206 1.43495 8.32462C1.06097 7.40717 0.963113 6.39763 1.15377 5.42367C1.34442 4.44972 1.81502 3.55508 2.50606 2.85289C2.7128 2.64281 2.7128 2.30219 2.50606 2.09211C2.29931 1.88203 1.9641 1.88203 1.75735 2.09211C0.918241 2.94477 0.346799 4.03111 0.115289 5.21378C-0.11622 6.39644 0.00260126 7.6223 0.456728 8.73635C0.910855 9.85039 1.67989 10.8026 2.66659 11.4725C3.65328 12.1424 4.81332 12.5 6 12.5C7.18669 12.5 8.34673 12.1424 9.33342 11.4725C10.3201 10.8026 11.0892 9.85038 11.5433 8.73634C11.9974 7.62229 12.1162 6.39643 11.8847 5.21377C11.6532 4.0311 11.0818 2.94476 10.2426 2.0921Z"
                                fill="#697A8D" />
                        </svg>
                        <?php if (isAuth()): ?>
                            <p>Выход</p>
                        <?php endif; ?>

                    </a>
                </div>



                <img id="lungeClick" class="profile-img" src="<?= $user['image'] ?>" alt="">
                <script>
    
    let lunge =document.getElementById('lunge');
    let lungeClick =document.getElementById('lungeClick');
    lungeClick.addEventListener('click', function(){
        if(lunge.style.display == 'flex'){
            lunge.style.display = 'none';    
        }
        else{
            lunge.style.display = 'flex';
        }

    })
</script>
            </header>
        
        <div class="burger" id="burger">
            ≡
        </div>
        <div class="burger" id="burgerKrest">
            ✕
        </div>
        <div class="flex">
            <?php if (isRole()): ?>
                <div class="navigation">
                    <nav>
                        <a href="?page=adminUsers" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'adminUsers')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.86971 9.715C6.84721 9.715 6.83221 9.715 6.80971 9.715C6.77221 9.7075 6.71971 9.7075 6.67471 9.715C4.49971 9.6475 2.85721 7.9375 2.85721 5.83C2.85721 3.685 4.60471 1.9375 6.74971 1.9375C8.89471 1.9375 10.6422 3.685 10.6422 5.83C10.6347 7.9375 8.98471 9.6475 6.89221 9.715C6.88471 9.715 6.87721 9.715 6.86971 9.715ZM6.74971 3.0625C5.22721 3.0625 3.98221 4.3075 3.98221 5.83C3.98221 7.33 5.15221 8.5375 6.64471 8.59C6.68971 8.5825 6.78721 8.5825 6.88471 8.59C8.35471 8.5225 9.50971 7.315 9.51721 5.83C9.51721 4.3075 8.27221 3.0625 6.74971 3.0625Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M12.4047 9.8125C12.3822 9.8125 12.3597 9.8125 12.3372 9.805C12.0297 9.835 11.7147 9.6175 11.6847 9.31C11.6547 9.0025 11.8422 8.725 12.1497 8.6875C12.2397 8.68 12.3372 8.68 12.4197 8.68C13.5147 8.62 14.3697 7.72 14.3697 6.6175C14.3697 5.4775 13.4472 4.555 12.3072 4.555C11.9997 4.5625 11.7447 4.3075 11.7447 4C11.7447 3.6925 11.9997 3.4375 12.3072 3.4375C14.0622 3.4375 15.4947 4.87 15.4947 6.625C15.4947 8.35 14.1447 9.745 12.4272 9.8125C12.4197 9.8125 12.4122 9.8125 12.4047 9.8125Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M6.87721 17.9125C5.40721 17.9125 3.92971 17.5375 2.81221 16.7875C1.76971 16.0975 1.19971 15.1525 1.19971 14.125C1.19971 13.0975 1.76971 12.145 2.81221 11.4475C5.06221 9.955 8.70721 9.955 10.9422 11.4475C11.9772 12.1375 12.5547 13.0825 12.5547 14.11C12.5547 15.1375 11.9847 16.09 10.9422 16.7875C9.81721 17.5375 8.34721 17.9125 6.87721 17.9125ZM3.43471 12.3925C2.71471 12.8725 2.32471 13.4875 2.32471 14.1325C2.32471 14.77 2.72221 15.385 3.43471 15.8575C5.30221 17.11 8.45221 17.11 10.3197 15.8575C11.0397 15.3775 11.4297 14.7625 11.4297 14.1175C11.4297 13.48 11.0322 12.865 10.3197 12.3925C8.45221 11.1475 5.30221 11.1475 3.43471 12.3925Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M13.7547 16.5625C13.4922 16.5625 13.2597 16.3825 13.2072 16.1125C13.1472 15.805 13.3422 15.5125 13.6422 15.445C14.1147 15.3475 14.5497 15.16 14.8872 14.8975C15.3147 14.575 15.5472 14.17 15.5472 13.7425C15.5472 13.315 15.3147 12.91 14.8947 12.595C14.5647 12.34 14.1522 12.16 13.6647 12.0475C13.3647 11.98 13.1697 11.68 13.2372 11.3725C13.3047 11.0725 13.6047 10.8775 13.9122 10.945C14.5572 11.0875 15.1197 11.3425 15.5772 11.695C16.2747 12.22 16.6722 12.9625 16.6722 13.7425C16.6722 14.5225 16.2672 15.265 15.5697 15.7975C15.1047 16.1575 14.5197 16.42 13.8747 16.5475C13.8297 16.5625 13.7922 16.5625 13.7547 16.5625Z"
                                            fill="#7A7A7A" />
                                    </svg>

                                    <p>Пользователи</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                            <a href="?page=adminCourses" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'adminCourses')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.25 19.0625H6.75C2.6775 19.0625 0.9375 17.3225 0.9375 13.25V8.75C0.9375 4.6775 2.6775 2.9375 6.75 2.9375H11.25C15.3225 2.9375 17.0625 4.6775 17.0625 8.75V13.25C17.0625 17.3225 15.3225 19.0625 11.25 19.0625ZM6.75 4.0625C3.2925 4.0625 2.0625 5.2925 2.0625 8.75V13.25C2.0625 16.7075 3.2925 17.9375 6.75 17.9375H11.25C14.7075 17.9375 15.9375 16.7075 15.9375 13.25V8.75C15.9375 5.2925 14.7075 4.0625 11.25 4.0625H6.75Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M6.51 13.4975C6.195 13.4975 5.9025 13.4225 5.6475 13.28C5.025 12.9275 4.6875 12.23 4.6875 11.315V3.83C4.6875 3.5225 4.9425 3.2675 5.25 3.2675C5.5575 3.2675 5.8125 3.5225 5.8125 3.83V11.315C5.8125 11.8025 5.955 12.1625 6.2025 12.2975C6.465 12.4475 6.87 12.3725 7.3125 12.11L8.3025 11.5175C8.7075 11.2775 9.285 11.2775 9.69 11.5175L10.68 12.11C11.13 12.38 11.535 12.4475 11.79 12.2975C12.0375 12.155 12.18 11.795 12.18 11.315V3.83C12.18 3.5225 12.435 3.2675 12.7425 3.2675C13.05 3.2675 13.305 3.5225 13.305 3.83V11.315C13.305 12.23 12.9675 12.9275 12.345 13.28C11.7225 13.6325 10.905 13.5575 10.1025 13.0775L9.1125 12.485C9.0675 12.455 8.925 12.455 8.88 12.485L7.89 13.0775C7.425 13.355 6.945 13.4975 6.51 13.4975Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M11.25 19.0625H6.75C2.6775 19.0625 0.9375 17.3225 0.9375 13.25V8.75C0.9375 4.6775 2.6775 2.9375 6.75 2.9375H11.25C15.3225 2.9375 17.0625 4.6775 17.0625 8.75V13.25C17.0625 17.3225 15.3225 19.0625 11.25 19.0625ZM6.75 4.0625C3.2925 4.0625 2.0625 5.2925 2.0625 8.75V13.25C2.0625 16.7075 3.2925 17.9375 6.75 17.9375H11.25C14.7075 17.9375 15.9375 16.7075 15.9375 13.25V8.75C15.9375 5.2925 14.7075 4.0625 11.25 4.0625H6.75Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M6.51 13.4975C6.195 13.4975 5.9025 13.4225 5.6475 13.28C5.025 12.9275 4.6875 12.23 4.6875 11.315V3.83C4.6875 3.5225 4.9425 3.2675 5.25 3.2675C5.5575 3.2675 5.8125 3.5225 5.8125 3.83V11.315C5.8125 11.8025 5.955 12.1625 6.2025 12.2975C6.465 12.4475 6.87 12.3725 7.3125 12.11L8.3025 11.5175C8.7075 11.2775 9.285 11.2775 9.69 11.5175L10.68 12.11C11.13 12.38 11.535 12.4475 11.79 12.2975C12.0375 12.155 12.18 11.795 12.18 11.315V3.83C12.18 3.5225 12.435 3.2675 12.7425 3.2675C13.05 3.2675 13.305 3.5225 13.305 3.83V11.315C13.305 12.23 12.9675 12.9275 12.345 13.28C11.7225 13.6325 10.905 13.5575 10.1025 13.0775L9.1125 12.485C9.0675 12.455 8.925 12.455 8.88 12.485L7.89 13.0775C7.425 13.355 6.945 13.4975 6.51 13.4975Z"
                                            fill="#7A7A7A" />
                                    </svg>

                                    <p>Курсы</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                            <a href="?page=adminExercises" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'adminExercises')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.33333 2C1.78105 2 1.33333 2.44772 1.33333 3C1.33333 3.55228 1.78105 4 2.33333 4C2.88562 4 3.33333 3.55228 3.33333 3C3.33333 2.44772 2.88562 2 2.33333 2ZM2.33333 6.66667C1.78105 6.66667 1.33333 7.11438 1.33333 7.66667C1.33333 8.21895 1.78105 8.66667 2.33333 8.66667C2.88562 8.66667 3.33333 8.21895 3.33333 7.66667C3.33333 7.11438 2.88562 6.66667 2.33333 6.66667ZM1.33333 12.3333C1.33333 11.781 1.78105 11.3333 2.33333 11.3333C2.88562 11.3333 3.33333 11.781 3.33333 12.3333C3.33333 12.8856 2.88562 13.3333 2.33333 13.3333C1.78105 13.3333 1.33333 12.8856 1.33333 12.3333ZM5.66667 2C5.11438 2 4.66667 2.44772 4.66667 3C4.66667 3.55228 5.11438 4 5.66667 4H13.6667C14.219 4 14.6667 3.55228 14.6667 3C14.6667 2.44772 14.219 2 13.6667 2H5.66667ZM4.66667 7.66667C4.66667 7.11438 5.11438 6.66667 5.66667 6.66667H13.6667C14.219 6.66667 14.6667 7.11438 14.6667 7.66667C14.6667 8.21895 14.219 8.66667 13.6667 8.66667H5.66667C5.11438 8.66667 4.66667 8.21895 4.66667 7.66667ZM5.66667 11.3333C5.11438 11.3333 4.66667 11.781 4.66667 12.3333C4.66667 12.8856 5.11438 13.3333 5.66667 13.3333H13.6667C14.219 13.3333 14.6667 12.8856 14.6667 12.3333C14.6667 11.781 14.219 11.3333 13.6667 11.3333H5.66667Z"
                                            fill="#7A7A7A" />
                                    </svg>

                                    <p>Задания</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                            <a href="?page=settings" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'settings')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_237_629)">
                                            <path
                                                d="M10 14.125C8.275 14.125 6.875 12.725 6.875 11C6.875 9.275 8.275 7.875 10 7.875C11.725 7.875 13.125 9.275 13.125 11C13.125 12.725 11.725 14.125 10 14.125ZM10 9.125C8.96667 9.125 8.125 9.96667 8.125 11C8.125 12.0333 8.96667 12.875 10 12.875C11.0333 12.875 11.875 12.0333 11.875 11C11.875 9.96667 11.0333 9.125 10 9.125Z"
                                                fill="#7A7A7A" />
                                            <path
                                                d="M12.675 19.4917C12.5 19.4917 12.325 19.4667 12.15 19.425C11.6333 19.2833 11.2 18.9583 10.925 18.5L10.825 18.3333C10.3333 17.4833 9.65833 17.4833 9.16667 18.3333L9.075 18.4917C8.8 18.9583 8.36667 19.2917 7.85 19.425C7.325 19.5667 6.78334 19.4917 6.325 19.2167L4.89167 18.3917C4.38333 18.1 4.01667 17.625 3.85833 17.05C3.70833 16.475 3.78333 15.8833 4.075 15.375C4.31667 14.95 4.38333 14.5667 4.24167 14.325C4.1 14.0833 3.74167 13.9417 3.25 13.9417C2.03333 13.9417 1.04167 12.95 1.04167 11.7333V10.2667C1.04167 9.05001 2.03333 8.05835 3.25 8.05835C3.74167 8.05835 4.1 7.91668 4.24167 7.67502C4.38333 7.43335 4.325 7.05002 4.075 6.62502C3.78333 6.11668 3.70833 5.51668 3.85833 4.95001C4.00833 4.37501 4.375 3.90001 4.89167 3.60835L6.33333 2.78335C7.275 2.22501 8.51667 2.55001 9.08333 3.50835L9.18334 3.67501C9.675 4.52501 10.35 4.52501 10.8417 3.67501L10.9333 3.51668C11.5 2.55001 12.7417 2.22501 13.6917 2.79168L15.125 3.61668C15.6333 3.90835 16 4.38335 16.1583 4.95835C16.3083 5.53335 16.2333 6.12502 15.9417 6.63335C15.7 7.05835 15.6333 7.44168 15.775 7.68335C15.9167 7.92502 16.275 8.06668 16.7667 8.06668C17.9833 8.06668 18.975 9.05835 18.975 10.275V11.7417C18.975 12.9583 17.9833 13.95 16.7667 13.95C16.275 13.95 15.9167 14.0917 15.775 14.3333C15.6333 14.575 15.6917 14.9583 15.9417 15.3833C16.2333 15.8917 16.3167 16.4917 16.1583 17.0583C16.0083 17.6333 15.6417 18.1083 15.125 18.4L13.6833 19.225C13.3667 19.4 13.025 19.4917 12.675 19.4917ZM10 16.4083C10.7417 16.4083 11.4333 16.875 11.9083 17.7L12 17.8583C12.1 18.0333 12.2667 18.1583 12.4667 18.2083C12.6667 18.2583 12.8667 18.2333 13.0333 18.1333L14.475 17.3C14.6917 17.175 14.8583 16.9667 14.925 16.7167C14.9917 16.4667 14.9583 16.2083 14.8333 15.9917C14.3583 15.175 14.3 14.3333 14.6667 13.6917C15.0333 13.05 15.7917 12.6833 16.7417 12.6833C17.275 12.6833 17.7 12.2583 17.7 11.725V10.2583C17.7 9.73335 17.275 9.30001 16.7417 9.30001C15.7917 9.30001 15.0333 8.93335 14.6667 8.29168C14.3 7.65002 14.3583 6.80835 14.8333 5.99168C14.9583 5.77501 14.9917 5.51668 14.925 5.26668C14.8583 5.01668 14.7 4.81668 14.4833 4.68335L13.0417 3.85835C12.6833 3.64168 12.2083 3.76668 11.9917 4.13335L11.9 4.29168C11.425 5.11668 10.7333 5.58335 9.99167 5.58335C9.25 5.58335 8.55833 5.11668 8.08333 4.29168L7.99167 4.12501C7.78334 3.77501 7.31667 3.65001 6.95834 3.85835L5.51667 4.69168C5.3 4.81668 5.13333 5.02502 5.06667 5.27502C5 5.52502 5.03333 5.78335 5.15833 6.00002C5.63333 6.81668 5.69167 7.65835 5.325 8.30002C4.95833 8.94168 4.2 9.30835 3.25 9.30835C2.71667 9.30835 2.29167 9.73335 2.29167 10.2667V11.7333C2.29167 12.2583 2.71667 12.6917 3.25 12.6917C4.2 12.6917 4.95833 13.0583 5.325 13.7C5.69167 14.3417 5.63333 15.1833 5.15833 16C5.03333 16.2167 5 16.475 5.06667 16.725C5.13333 16.975 5.29167 17.175 5.50833 17.3083L6.95 18.1333C7.125 18.2417 7.33333 18.2667 7.525 18.2167C7.725 18.1667 7.89167 18.0333 8 17.8583L8.09167 17.7C8.56667 16.8833 9.25834 16.4083 10 16.4083Z"
                                                fill="#7A7A7A" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_237_629">
                                                <rect width="20" height="20" fill="white" transform="matrix(1 0 0 -1 0 20.94)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <p>Настройки</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                        </nav>
                    </div>
            <?php else: ?>
                <div class="navigation">
                    <nav>
                        <a href="?page=learning" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'learning')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.8398 0.969971H10C9.6875 0.969971 9.38802 1.02856 9.10156 1.14575C8.8151 1.26294 8.5612 1.41919 8.33984 1.6145C8.11849 1.41919 7.86458 1.26294 7.57812 1.14575C7.29167 1.02856 6.99219 0.969971 6.67969 0.969971H0.839844C0.605469 0.969971 0.406901 1.05135 0.244141 1.21411C0.0813802 1.37687 0 1.57544 0 1.80981V14.3098C0 14.5312 0.0813802 14.7232 0.244141 14.886C0.406901 15.0487 0.605469 15.1301 0.839844 15.1301H5.64453C5.86589 15.1301 6.07747 15.1724 6.2793 15.2571C6.48112 15.3417 6.66016 15.4622 6.81641 15.6184L7.75391 16.5559C7.75391 16.5559 7.75716 16.5592 7.76367 16.5657C7.77018 16.5722 7.77344 16.5754 7.77344 16.5754C7.8125 16.6145 7.85156 16.6471 7.89062 16.6731C7.92969 16.6991 7.97526 16.7187 8.02734 16.7317C8.06641 16.7577 8.11523 16.7773 8.17383 16.7903C8.23242 16.8033 8.28776 16.8098 8.33984 16.8098C8.39193 16.8098 8.44727 16.8033 8.50586 16.7903C8.56445 16.7773 8.61979 16.7577 8.67188 16.7317H8.65234C8.70443 16.7187 8.75 16.6991 8.78906 16.6731C8.82812 16.6471 8.86719 16.6145 8.90625 16.5754C8.90625 16.5754 8.9095 16.5722 8.91602 16.5657C8.92253 16.5592 8.92578 16.5559 8.92578 16.5559L9.86328 15.6184C10.0195 15.4752 10.1986 15.358 10.4004 15.2668C10.6022 15.1757 10.8138 15.1301 11.0352 15.1301H15.8398C16.0742 15.1301 16.2728 15.0487 16.4355 14.886C16.5983 14.7232 16.6797 14.5312 16.6797 14.3098V1.80981C16.6797 1.57544 16.5983 1.37687 16.4355 1.21411C16.2728 1.05135 16.0742 0.969971 15.8398 0.969971ZM5.64453 13.47H1.67969V2.63013H6.67969C6.90104 2.63013 7.0931 2.71151 7.25586 2.87427C7.41862 3.03703 7.5 3.2356 7.5 3.46997V14.0364C7.23958 13.8671 6.94987 13.7304 6.63086 13.6262C6.31185 13.5221 5.98307 13.47 5.64453 13.47ZM15 13.47H11.0352C10.7096 13.47 10.3874 13.5188 10.0684 13.6165C9.74935 13.7141 9.45312 13.8541 9.17969 14.0364V3.46997C9.17969 3.2356 9.26107 3.03703 9.42383 2.87427C9.58659 2.71151 9.77865 2.63013 10 2.63013H15V13.47Z"
                                            fill="#697A8D" />
                                    </svg>
                                    <p>Обучение</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                            <a href="?page=homework" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'homework')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="15" height="18" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0 0.600098H1.66016V17.2798H0V0.600098ZM5.83984 3.93994H11.6602V5.6001H5.83984V3.93994ZM5.83984 7.27979H11.6602V8.93994H5.83984V7.27979ZM13.3398 0.600098H2.5V17.2798H13.3398C13.7956 17.2798 14.1862 17.117 14.5117 16.7915C14.8372 16.466 15 16.0688 15 15.6001V2.27979C15 1.81104 14.8372 1.4139 14.5117 1.08838C14.1862 0.762857 13.7956 0.600098 13.3398 0.600098ZM13.3398 15.6001H4.16016V2.27979H13.3398V15.6001Z"
                                            fill="#7A7A7A" />
                                    </svg>
                                    <p>Домашние задания</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>

                            <a href="?page=catalog" class="nav-item <?php if (isset($_GET['page']) && $_GET['page'] == 'catalog')
                            echo 'active' ?>">
                                <div class="nav-info">
                                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.33398 10.3449C8.90648 10.3449 8.47106 10.2657 8.13064 10.1153L3.45981 8.04115C2.27231 7.51073 2.09814 6.79823 2.09814 6.41032C2.09814 6.0224 2.27231 5.3099 3.45981 4.77948L8.13064 2.70532C8.81939 2.39657 9.85648 2.39657 10.5452 2.70532L15.224 4.77948C16.4036 5.30198 16.5856 6.0224 16.5856 6.41032C16.5856 6.79823 16.4115 7.51073 15.224 8.04115L10.5452 10.1153C10.1969 10.2737 9.76939 10.3449 9.33398 10.3449ZM9.33398 3.66323C9.06481 3.66323 8.80356 3.70282 8.61356 3.7899L3.94273 5.86407C3.45981 6.08573 3.28564 6.3074 3.28564 6.41032C3.28564 6.51323 3.45981 6.74282 3.93481 6.95657L8.60564 9.03073C8.98564 9.19698 9.67439 9.19698 10.0544 9.03073L14.7331 6.95657C15.2161 6.74282 15.3902 6.51323 15.3902 6.41032C15.3902 6.3074 15.2161 6.07782 14.7331 5.86407L10.0623 3.7899C9.87231 3.71073 9.60314 3.66323 9.33398 3.66323Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M9.5 14.4696C9.19917 14.4696 8.89833 14.4062 8.61333 14.2796L3.23792 11.8887C2.4225 11.5325 1.78125 10.5429 1.78125 9.64832C1.78125 9.32373 2.05042 9.05457 2.375 9.05457C2.69958 9.05457 2.96875 9.32373 2.96875 9.64832C2.96875 10.0837 3.325 10.63 3.72083 10.8121L9.09625 13.2029C9.34958 13.3137 9.6425 13.3137 9.90375 13.2029L15.2792 10.8121C15.675 10.6379 16.0313 10.0837 16.0313 9.64832C16.0313 9.32373 16.3004 9.05457 16.625 9.05457C16.9496 9.05457 17.2188 9.32373 17.2188 9.64832C17.2188 10.5429 16.5775 11.5325 15.7621 11.8966L10.3867 14.2875C10.1017 14.4062 9.80083 14.4696 9.5 14.4696Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M9.5 18.4278C9.19917 18.4278 8.89833 18.3645 8.61333 18.2378L3.23792 15.847C2.35125 15.4511 1.78125 14.5724 1.78125 13.5986C1.78125 13.274 2.05042 13.0049 2.375 13.0049C2.69958 13.0049 2.96875 13.282 2.96875 13.6065C2.96875 14.1053 3.26167 14.5645 3.72083 14.7703L9.09625 17.1611C9.34958 17.272 9.6425 17.272 9.90375 17.1611L15.2792 14.7703C15.7383 14.5645 16.0313 14.1132 16.0313 13.6065C16.0313 13.282 16.3004 13.0128 16.625 13.0128C16.9496 13.0128 17.2188 13.282 17.2188 13.6065C17.2188 14.5803 16.6488 15.4591 15.7621 15.8549L10.3867 18.2457C10.1017 18.3645 9.80083 18.4278 9.5 18.4278Z"
                                            fill="#7A7A7A" />
                                    </svg>
                                    <p>Каталог</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </a>
                        </nav>
                    <?php if (!empty($Purchased)): ?>
                        <nav>
                            <div class="nav-item">
                                <div class="nav-info">
                                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.3332 18.0104H6.66653C2.81653 18.0104 2.09986 16.3084 1.91653 14.6538L1.29153 8.31252C1.19986 7.48127 1.17486 6.25418 2.04153 5.33585C2.79153 4.54418 4.0332 4.16418 5.8332 4.16418H14.1665C15.9749 4.16418 17.2165 4.5521 17.9582 5.33585C18.8249 6.25418 18.7999 7.48127 18.7082 8.32043L18.0832 14.6459C17.8999 16.3084 17.1832 18.0104 13.3332 18.0104ZM5.8332 5.34377C4.42486 5.34377 3.4582 5.60502 2.96653 6.12752C2.5582 6.55502 2.42486 7.2121 2.5332 8.19377L3.1582 14.535C3.29986 15.7859 3.6582 16.8229 6.66653 16.8229H13.3332C16.3332 16.8229 16.6999 15.7859 16.8415 14.5271L17.4665 8.20168C17.5749 7.2121 17.4415 6.55502 17.0332 6.12752C16.5415 5.60502 15.5749 5.34377 14.1665 5.34377H5.8332Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M13.3337 5.34379C12.992 5.34379 12.7087 5.07462 12.7087 4.75004V4.11671C12.7087 2.70754 12.7087 2.17712 10.667 2.17712H9.33366C7.29199 2.17712 7.29199 2.70754 7.29199 4.11671V4.75004C7.29199 5.07462 7.00866 5.34379 6.66699 5.34379C6.32533 5.34379 6.04199 5.07462 6.04199 4.75004V4.11671C6.04199 2.72337 6.04199 0.989624 9.33366 0.989624H10.667C13.9587 0.989624 13.9587 2.72337 13.9587 4.11671V4.75004C13.9587 5.07462 13.6753 5.34379 13.3337 5.34379Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M9.99967 13.2604C7.70801 13.2604 7.70801 11.9146 7.70801 11.1071V10.2917C7.70801 9.17542 7.99134 8.90625 9.16634 8.90625H10.833C12.008 8.90625 12.2913 9.17542 12.2913 10.2917V11.0833C12.2913 11.9067 12.2913 13.2604 9.99967 13.2604ZM8.95801 10.0938C8.95801 10.1571 8.95801 10.2283 8.95801 10.2917V11.1071C8.95801 11.9225 8.95801 12.0729 9.99967 12.0729C11.0413 12.0729 11.0413 11.9463 11.0413 11.0992V10.2917C11.0413 10.2283 11.0413 10.1571 11.0413 10.0938C10.9747 10.0938 10.8997 10.0938 10.833 10.0938H9.16634C9.09967 10.0938 9.02467 10.0938 8.95801 10.0938Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M11.6663 11.6929C11.3579 11.6929 11.0829 11.4712 11.0496 11.1704C11.0079 10.8458 11.2496 10.545 11.5913 10.5054C13.7913 10.2442 15.8996 9.45249 17.6746 8.2254C17.9496 8.02749 18.3413 8.09082 18.5496 8.35999C18.7496 8.62124 18.6913 8.99332 18.4079 9.19124C16.4579 10.5371 14.1579 11.4 11.7413 11.6929C11.7163 11.6929 11.6913 11.6929 11.6663 11.6929Z"
                                            fill="#7A7A7A" />
                                        <path
                                            d="M8.33296 11.7008C8.30796 11.7008 8.28296 11.7008 8.25796 11.7008C5.97463 11.4554 3.74963 10.6637 1.82463 9.41288C1.54129 9.2308 1.46629 8.85871 1.65796 8.58955C1.84963 8.32038 2.24129 8.24913 2.52463 8.43121C4.28296 9.57121 6.30796 10.2916 8.39129 10.5212C8.73296 10.5608 8.98296 10.8537 8.94129 11.1783C8.91629 11.4791 8.64963 11.7008 8.33296 11.7008Z"
                                            fill="#7A7A7A" />
                                    </svg>
                                    <p>Мои курсы</p>
                                </div>
                                <!--<p class="arrow">›</p>-->
                            </div>
                            <?php foreach ($Purchased as $item): ?>
                                <?php
                                $puchId = $item['courseId'];
                                $userCourses = $database->query("SELECT * FROM `courses` WHERE `id` = '$puchId'")->fetch(2);
                                ?>

                                <a href="/?page=course&id=<?= $userCourses['id'] ?>" class="nav-item">
                                    <div class="nav-info">
                                        <img src="assets/images/header/pseudo.png" alt="">
                                        <p>
                                            <?= $userCourses['name'] ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>

                        </nav>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'auth':
                    require('pages/pages-user/authorization.php');
                    break;
                case 'profile':
                    require('pages/pages-user/profile.php');
                    break;
                case 'homework':
                    require('pages/pages-user/homework.php');
                    break;
                case 'homework-q':
                    require('pages/pages-user/homework-questions.php');
                    break;
                case 'catalog':
                    require('pages/pages-user/catalog.php');
                    break;
                case 'etap':
                    require('pages/pages-user/etap.php');
                    break;
                case 'lesson':
                    require('pages/pages-user/lesson.php');
                    break;
                case 'course':
                    require('pages/pages-user/course.php');
                    break;
                case 'answers':
                    require('pages/pages-user/answers.php');
                    break;
                case 'learning':
                    require('pages/pages-user/learning.php');
                    break;
                case 'adminUsers':
                    require('pages/pages-admin/admin-users.php');
                    break;
                case 'adminCourses':
                    require('pages/pages-admin/admin-courses.php');
                    break;
                case 'adminExercises':
                    require('pages/pages-admin/admin-exercise.php');
                    break;
                case 'settings':
                    require('pages/pages-admin/settings.php');
                    break;
                case 'adminuserprofile':
                    require('pages/pages-admin/admin-user-profile.php');
                    break;
                case 'updateCourse':
                    require('pages/pages-admin/update-course.php');
                    break;
                case 'updateLesson':
                    require('pages/pages-admin/update-lesson.php');
                    break;
                case 'addHomework':
                    require('pages/pages-admin/add-homework.php');
                    break;
                case 'addtest':
                    require('pages/pages-admin/add-test.php');
                    break;
                case 'check':
                    require('pages/pages-admin/check.php');
                    break;

                default:
                    require('pages/pages-user/authorization.php');
                    break;
            }
        } else {
            require('pages/pages-user/authorization.php');
        }
        ?>
    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</body>

</html>

