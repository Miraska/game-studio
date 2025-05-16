<?php
session_start();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';


$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$pageFile = __DIR__ . '/../pages/' . $page . '.php';
if (!file_exists($pageFile)) {
    $pageFile = __DIR__ . '/../pages/home.php';
}

// API: поиск курсов
if (isset($_GET['api']) && $_GET['api'] == 'search_courses') {
    header('Content-Type: application/json; charset=utf-8');
    $result = [];
    if (!empty($_GET['q'])) {
        $result = getCoursesBySearch($pdo, $_GET['q']);
    }
    echo json_encode($result);
    exit;
}

// API: получить курс по id
if (isset($_GET['api']) && $_GET['api'] == 'get_course' && isset($_GET['id'])) {
    header('Content-Type: application/json; charset=utf-8');
    $course = getCourseById($pdo, $_GET['id']);
    echo json_encode($course);
    exit;
}


$filters = [];
if (isset($_GET['level'])) {
  $filters['level'] = $_GET['level'];
}
if (isset($_GET['search'])) {
  $filters['search'] = $_GET['search'];
}

$courses = getCourses($pdo, $filters);
$newCourses = array_slice($courses, 0, 4);
$topCourses = array_slice($courses, 0, 2);

// редирект если найден ровно 1 курс по поиску
if (!empty($_GET['search']) && count($courses) === 1) {
    header('Location: index.php?page=lesson&id=' . $courses[0]['id']);
    exit();
}

// Если AJAX запрос для автокомплита
if (isset($_GET['autocomplete']) && !empty($_GET['search'])) {
    $allCourses = getCourses($pdo, ['search' => $_GET['search']]);
    $result = [];
    foreach ($allCourses as $c) {
        $result[] = [
            'id' => $c['id'],
            'title' => $c['title']
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
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
        <?php
        if ($page === 'profile') {
            require_once "../includes/header_profile.php";
        } 
        elseif($page === 'profile_admin') {
            require_once "../includes/header_admin.php";
        }
        else {
            require_once "../includes/header.php";
        }

        ?>

        <main>
            <?php include $pageFile; ?>
        </main>
        <?php require_once "../includes/footer.php" ?>
    </div>



    <script src="js/main.js"></script>
</body>

</html>


