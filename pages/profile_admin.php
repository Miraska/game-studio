<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: index.php?page=home");
    exit();
}

$courses = getCourses($pdo);
$users = getAllUsers($pdo);
$purchases = getAllPurchases($pdo);
$user = getCurrentUser($pdo);
?>

<section class="profile-section">
    <!-- Модальное окно для добавления курса -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Добавить курс</h2>
                <span class="close"></span>
            </div>
            <form id="addProductForm" method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Название" required>
                <textarea name="description" placeholder="Описание" required></textarea>
                <input type="number" name="price" placeholder="Цена" step="0.01" required>
                <input type="number" name="lessons_count" placeholder="Кол-во уроков" required>
                <select name="level" required>
                    <option value="beginner">Начальный</option>
                    <option value="intermediate">Средний</option>
                    <option value="advanced">Продвинутый</option>
                </select>
                <input type="file" name="image" accept="image/*">
                <button type="submit">Добавить</button>
            </form>
        </div>
    </div>

    <!-- Модальное окно для редактирования курса -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Изменить курс</h2>
                <span class="close"></span>
            </div>
            <form id="editProductForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit-course-id">
                <input type="text" name="title" id="edit-title" placeholder="Название" required>
                <textarea name="description" id="edit-description" placeholder="Описание" required></textarea>
                <input type="number" name="price" id="edit-price" placeholder="Цена" step="0.01" required>
                <input type="number" name="lessons_count" id="edit-lessons_count" placeholder="Кол-во уроков" required>
                <select name="level" id="edit-level" required>
                    <option value="beginner">Начальный</option>
                    <option value="intermediate">Средний</option>
                    <option value="advanced">Продвинутый</option>
                </select>
                <input type="file" name="image" accept="image/*">
                <button type="submit">Сохранить</button>
            </form>
        </div>
    </div>

    <!-- Модальное окно для редактирования пользователя -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Изменить пользователя</h2>
                <span class="close"></span>
            </div>
            <form id="editUserForm" method="post">
                <input type="hidden" name="id" id="edit-user-id">
                <input type="text" name="username" id="edit-username" placeholder="Имя пользователя" required>
                <input type="email" name="email" id="edit-email" placeholder="Почта" required>
                <input type="password" name="password" placeholder="Новый пароль (опционально)">
                <select name="role" id="edit-role" required>
                    <option value="admin">Админ</option>
                    <option value="instructor">Преподаватель</option>
                    <option value="student">Ученик</option>
                </select>
                <label><input type="checkbox" name="is_active" id="edit-is_active"> Активен</label>
                <button type="submit">Сохранить</button>
            </form>
        </div>
    </div>

    <div class="profile-left">
        <div><img src="images/icons/user_profile.png" alt=""></div>
        <div class="profile-left-inner">
            <p><?= escape($user['username']) ?></p>
            <p id="second"><?= escape($user['role']) ?></p>
            <p id="third"><?= escape($user['email']) ?></p>
            <div>
                <a href="logout.php" class="btn-primary" style="background-color: #9E5CF2; color: #fff; padding: 6px 20px; border-radius: 8px;">Выйти</a>
            </div>
        </div>
    </div>

    <div class="profile-right">
        <h1>Админ панель</h1>
        <div class="tables">
            <h2>Управление курсами</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?= $course['id'] ?></td>
                                <td><?= escape($course['title']) ?></td>
                                <td><?= number_format($course['price'], 2) ?> руб</td>
                                <td>
                                    <button class="default-button-table edit-course" data-course-id="<?= $course['id'] ?>">Редактировать</button> |
                                    <button class="default-button-table delete-course" onclick="window.location.href='index.php?page=profile_admin&delete_course=<?= $course['id'] ?>'">Удалить</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn-primary" onclick="openModal('addProductModal')">Добавить курс</button>

            <h2 class="mt-2">Управление пользователями</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= escape($user['username']) ?></td>
                                <td><?= escape($user['email']) ?></td>
                                <td><?= escape($user['role']) ?></td>
                                <td>
                                    <button class="default-button-table edit-user" data-user-id="<?= $user['id'] ?>">Редактировать</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h2 class="mt-2">Управление заказами</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID заказа</th>
                            <th>Название</th>
                            <th>Пользователь</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $purchase): ?>
                            <tr>
                                <td><?= $purchase['id'] ?></td>
                                <td><?= escape($purchase['course_title']) ?></td>
                                <td><?= escape($purchase['user_name']) ?></td>
                                <td><?= date('d.m.Y', strtotime($purchase['purchase_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'lessons_count' => $_POST['lessons_count'],
        'level' => $_POST['level'],
        'image_path' => ''
    ];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/courses/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
        $data['image_path'] = $fileName;
    }
    if (createCourse($pdo, $data)) {
        $_SESSION['success_message'] = "Курс успешно добавлен.";
    }
    header("Location: index.php?page=profile_admin");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'lessons_count' => $_POST['lessons_count'],
        'level' => $_POST['level']
    ];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/courses/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
        $data['image_path'] = $fileName;
    }
    if (updateCourse($pdo, $_POST['id'], $data)) {
        $_SESSION['success_message'] = "Курс успешно обновлен.";
    }
    header("Location: index.php?page=profile_admin");
    exit();
}

if (isset($_GET['delete_course'])) {
    deleteCourse($pdo, (int)$_GET['delete_course']);
    $_SESSION['success_message'] = "Курс удален.";
    header("Location: index.php?page=profile_admin");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !isset($_POST['title'])) {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'role' => $_POST['role'],
        'is_active' => isset($_POST['is_active']) ? 1 : 0
    ];
    if (!empty($_POST['password'])) {
        $data['password'] = $_POST['password'];
    }
    if (updateUser($pdo, $_POST['id'], $data)) {
        $_SESSION['success_message'] = "Пользователь обновлен.";
    }
    header("Location: index.php?page=profile_admin");
    exit();
}

?>