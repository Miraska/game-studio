<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    $_SESSION['errors'] = ["Для добавления отзыва необходимо авторизоваться"];
    header("Location: index.php?page=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment'] ?? '');
    $user_id = $_SESSION['user_id'];

    // Валидация
    $errors = [];

    if (!hasPurchasedCourse($pdo, $user_id, $course_id)) {
        $errors[] = "Вы не можете оставить отзыв на курс, который не приобрели";
    }

    if ($rating < 1 || $rating > 5) {
        $errors[] = "Рейтинг должен быть от 1 до 5";
    }

    if (empty($comment)) {
        $errors[] = "Текст отзыва обязателен";
    }

    if (empty($errors)) {
        if (addReview($pdo, $user_id, $course_id, $rating, $comment)) {
            $_SESSION['success_message'] = "Отзыв успешно добавлен!";
        } else {
            $errors[] = "Ошибка при добавлении отзыва";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
}

header("Location: index.php?page=lesson&id=$course_id");
exit();
?>