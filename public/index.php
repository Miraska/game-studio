<?php
session_start();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Определяем, какую страницу загружать
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$pageFile = __DIR__ . '/../pages/' . $page . '.php';
if (!file_exists($pageFile)) {
    $pageFile = __DIR__ . '/../pages/home.php';
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>GameStudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GameStudio - онлайн-курсы по разработке игр. Учитесь у лучших преподавателей и создавайте свои проекты.">
    <meta name="keywords" content="онлайн-курсы, разработка игр, обучение, GameStudio">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Шапка -->
        <?php
        if ($page === 'profile' || $page === 'profile_admin') {
            require_once "../includes/header_profile.php";
        } else {
            require_once "../includes/header.php";
        }

        ?>

        <!-- Основной контент -->
        <main>
            <?php include $pageFile; ?>
        </main>
        <!-- Футер -->
        <?php require_once "../includes/footer.php" ?>
    </div>



    <script src="js/main.js"></script>
</body>

</html>