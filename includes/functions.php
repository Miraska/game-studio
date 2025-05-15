<?php
require_once __DIR__ . '/db.php';

// Регистрация пользователя
function registerUser($pdo, $username, $email, $password, $role = 'student')
{
    // Проверка на существование пользователя
    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email]);

    if ($stmt->fetchColumn() > 0) {
        return "Пользователь с таким именем или email уже существует.";
    }

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Создание пользователя
    $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email'    => $email,
        'password' => $hashedPassword,
        'role'     => $role
    ]);

    return true;
}

// Добавить в includes/functions.php
function getUserById($pdo, $id)
{
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Авторизация пользователя
// Исправление функции в includes/functions.php
function loginUser($pdo, $email, $password)
{
    $sql = "SELECT * FROM users WHERE email = :email AND is_active = TRUE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        return true;
    }
    return false;
}

// Выход пользователя
function logoutUser()
{
    session_unset();
    session_destroy();
}

// Проверка авторизации
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Получение текущего пользователя
function getCurrentUser($pdo)
{
    if (!isLoggedIn()) return null;

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Проверка роли
function isAdmin()
{
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function isInstructor()
{
    return isLoggedIn() && $_SESSION['role'] === 'instructor';
}

// Получение курсов
function getCourses($pdo, $filters = [])
{
    $where = [];
    $params = [];

    if (!empty($filters['level'])) {
        $where[] = "level = :level";
        $params['level'] = $filters['level'];
    }

    if (!empty($filters['search'])) {
        $where[] = "(title LIKE :search OR description LIKE :search)";
        $params['search'] = "%{$filters['search']}%";
    }

    $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

    $sql = "SELECT * FROM courses $whereClause ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение курса по ID
function getCourseById($pdo, $id)
{
    $sql = "SELECT * FROM courses WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Получение уроков курса
function getLessonsByCourse($pdo, $course_id)
{
    $sql = "SELECT * FROM lessons WHERE course_id = :course_id ORDER BY order_number";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['course_id' => $course_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Проверка, купил ли пользователь курс
function hasPurchasedCourse($pdo, $user_id, $course_id)
{
    $sql = "SELECT COUNT(*) FROM purchases WHERE user_id = :user_id AND course_id = :course_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);
    return $stmt->fetchColumn() > 0;
}

// Покупка курса
function purchaseCourse($pdo, $user_id, $course_id)
{
    $course = getCourseById($pdo, $course_id);
    if (!$course) return false;

    $sql = "INSERT INTO purchases (user_id, course_id, price_paid) VALUES (:user_id, :course_id, :price)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'user_id' => $user_id,
        'course_id' => $course_id,
        'price' => $course['price']
    ]);
}

// Получение курсов пользователя
function getUserCourses($pdo, $user_id)
{
    $sql = "SELECT c.* FROM courses c 
            JOIN purchases p ON c.id = p.course_id 
            WHERE p.user_id = :user_id
            ORDER BY p.purchase_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение всех пользователей (для админки)
function getAllUsers($pdo)
{
    $sql = "SELECT id, username, email, role, is_active, created_at FROM users ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Обновление пользователя (для админки)
function updateUser($pdo, $id, $data)
{
    $set = [];
    $params = ['id' => $id];

    if (!empty($data['username'])) {
        $set[] = "username = :username";
        $params['username'] = $data['username'];
    }

    if (!empty($data['email'])) {
        $set[] = "email = :email";
        $params['email'] = $data['email'];
    }

    if (!empty($data['role'])) {
        $set[] = "role = :role";
        $params['role'] = $data['role'];
    }

    if (isset($data['is_active'])) {
        $set[] = "is_active = :is_active";
        $params['is_active'] = (bool)$data['is_active'];
    }

    if (!empty($data['password'])) {
        $set[] = "password = :password";
        $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    if (empty($set)) return false;

    $sql = "UPDATE users SET " . implode(", ", $set) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// Создание курса (для админки)
function createCourse($pdo, $data)
{
    $sql = "INSERT INTO courses (title, description, price, lessons_count, level, image_path) 
            VALUES (:title, :description, :price, :lessons_count, :level, :image_path)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'title' => $data['title'],
        'description' => $data['description'],
        'price' => $data['price'],
        'lessons_count' => $data['lessons_count'],
        'level' => $data['level'],
        'image_path' => $data['image_path']
    ]);
}

// Обновление курса (для админки)
function updateCourse($pdo, $id, $data)
{
    $set = [];
    $params = ['id' => $id];

    if (!empty($data['title'])) {
        $set[] = "title = :title";
        $params['title'] = $data['title'];
    }

    if (!empty($data['description'])) {
        $set[] = "description = :description";
        $params['description'] = $data['description'];
    }

    if (!empty($data['price'])) {
        $set[] = "price = :price";
        $params['price'] = $data['price'];
    }

    if (!empty($data['lessons_count'])) {
        $set[] = "lessons_count = :lessons_count";
        $params['lessons_count'] = $data['lessons_count'];
    }

    if (!empty($data['level'])) {
        $set[] = "level = :level";
        $params['level'] = $data['level'];
    }

    if (!empty($data['image_path'])) {
        $set[] = "image_path = :image_path";
        $params['image_path'] = $data['image_path'];
    }

    if (empty($set)) return false;

    $sql = "UPDATE courses SET " . implode(", ", $set) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// Удаление курса (для админки)
function deleteCourse($pdo, $id)
{
    $sql = "DELETE FROM courses WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

// Получение всех покупок (для админки)
function getAllPurchases($pdo)
{
    $sql = "SELECT p.*, u.username as user_name, c.title as course_title 
            FROM purchases p
            JOIN users u ON p.user_id = u.id
            JOIN courses c ON p.course_id = c.id
            ORDER BY p.purchase_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Добавление отзыва
function addReview($pdo, $user_id, $course_id, $rating, $comment)
{
    $sql = "INSERT INTO reviews (user_id, course_id, rating, comment) 
            VALUES (:user_id, :course_id, :rating, :comment)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'user_id' => $user_id,
        'course_id' => $course_id,
        'rating' => $rating,
        'comment' => $comment
    ]);
}

// Получение отзывов курса
function getCourseReviews($pdo, $course_id)
{
    $sql = "SELECT r.*, u.username 
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.course_id = :course_id
            ORDER BY r.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['course_id' => $course_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
