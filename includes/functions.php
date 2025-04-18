<?php
function registerUser($pdo, $username, $email, $password) {
    // Проверяем, не занято ли имя/почта
    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return "Пользователь с таким именем или email уже существует.";
    }

    $hashedPassword = $password;

    // Вставляем новую запись
    $sql = "INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email'    => $email,
        'password' => $hashedPassword
    ]);

    return true; 
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password == $user['password']) {
        return $user;
    }
    return false;
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id'       => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role'     => $_SESSION['role']
        ];
    }
    return null;
}

function isAdmin() {
    return (isLoggedIn() && $_SESSION['role'] === 'admin');
}

function isInstructor() {
    return (isLoggedIn() && $_SESSION['role'] === 'instructor');
}

?>



