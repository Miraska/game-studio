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
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Шапка -->
        <?php require_once "../includes/header.php"?>

        <!-- Основной контент -->
        <main>
            <?php include $pageFile; ?>
        </main>
        <!-- Футер -->
        <footer class="site-footer">
            <div class="footer-container">
                <p>© 2025 GameStudio. Все права защищены.</p>
            </div>
        </footer>
    </div>
    <script src="js/main.js"></script>
</body>

</html>