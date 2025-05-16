<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

if (!isLoggedIn() || !isInstructor()) {
    header("Location: ../index.php?page=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf']) && isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];
    $uploadDir = __DIR__ . '/../pdf/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $filename = time() . '_' . basename($_FILES['pdf']['name']);
    move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadDir . $filename);
    $_SESSION['success_message'] = "Файл успешно загружен!";
}
header("Location: ../index.php?page=lesson&id=$course_id");
exit();
?>
