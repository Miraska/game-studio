<?php

$db   = 'gamestudio';   // Имя базы данных
$user = 'root';         // Логин к MySQL
$pass = '';             // Пароль к MySQL

try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Функция для защиты от XSS
function escape($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
