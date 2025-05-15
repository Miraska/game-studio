<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Валидация
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно";
    } elseif (strlen($username) < 3) {
        $errors[] = "Имя пользователя должно быть не менее 3 символов";
    }
    
    if (empty($email)) {
        $errors[] = "Email обязателен";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email";
    }
    
    if (empty($password)) {
        $errors[] = "Пароль обязателен";
    } elseif (strlen($password) < 6) {
        $errors[] = "Пароль должен быть не менее 6 символов";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают";
    }
    
    if (empty($errors)) {
        $result = registerUser($pdo, $username, $email, $password);
        
        if ($result === true) {
            $_SESSION['success_message'] = "Регистрация прошла успешно! Теперь вы можете войти.";
            header("Location: index.php?page=home");
            exit();
        } else {
            $errors[] = $result;
        }
    }
    
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = [
        'username' => $username,
        'email' => $email
    ];
    header("Location: index.php?page=home");
    exit();
}
?>