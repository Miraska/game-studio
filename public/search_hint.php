<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$q = trim($_GET['q'] ?? '');

$hints = [];
if ($q !== '') {
    $filters = ['search' => $q];
    $courses = getCourses($pdo, $filters);
    foreach ($courses as $course) {
        $hints[] = [
            'id' => $course['id'],
            'title' => $course['title'],
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($hints);
