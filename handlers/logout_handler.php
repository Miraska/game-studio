<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

logoutUser();
header("Location: index.php?page=home");
exit();
?>