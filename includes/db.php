<?php

$db   = 'gamestudio';   // Имя базы данных
$user = 'root';            // Логин к MySQL
$pass = '';                // Пароль к MySQL (если есть)

try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=gamestudio;charset=utf8", $user, $pass);
    // Устанавливаем режим ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
