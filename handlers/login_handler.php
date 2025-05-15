<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Валидация
    $errors = [];

    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно";
    }

    if (empty($password)) {
        $errors[] = "Пароль обязателен";
    }

    if (empty($errors)) {
        if (loginUser($pdo, $username, $password)) {
            header("Location: index.php?page=home");
            exit();
        } else {
            $errors[] = "Неверное имя пользователя или пароль";
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: index.php?page=home");
    exit();
}
