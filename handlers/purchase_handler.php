<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    $_SESSION['errors'] = ["Для покупки курса необходимо авторизоваться"];
    header("Location: index.php?page=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    if (hasPurchasedCourse($pdo, $user_id, $course_id)) {
        $_SESSION['errors'] = ["Вы уже приобрели этот курс"];
    } elseif (purchaseCourse($pdo, $user_id, $course_id)) {
        $_SESSION['success_message'] = "Курс успешно приобретен!";
    } else {
        $_SESSION['errors'] = ["Ошибка при покупке курса"];
    }
}

header("Location: index.php?page=lesson&id=$course_id");
exit();
?>