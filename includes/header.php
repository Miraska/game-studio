<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

if (isset($_SESSION['errors'])) {
    echo '<div class="errors">';
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>$error</p>";
    }
    echo '</div>';
    unset($_SESSION['errors']);
}
if (isset($_SESSION['success_message'])) {
    echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signinForm'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $isLogined = loginUser($pdo, $email, $password);

    if (isAdmin()) {
        header("Location: index.php?page=profile_admin");
        exit();
    }

    if ($isLogined) {
        header("Location: index.php?page=profile");
        exit();
    } else {
        $_SESSION['errors'][] = "Неверный email или пароль.";
        header("Location: index.php?page=home");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signupForm'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['errors'][] = "Пароли не совпадают.";
    } elseif (strlen($password) < 6) {
        $_SESSION['errors'][] = "Пароль должен содержать минимум 6 символов.";
    } else {
        if (registerUser($pdo, $username, $email, $password)) {
            $_SESSION['success_message'] = "Регистрация прошла успешно! Войдите в систему.";
            header("Location: index.php?page=home");
            exit();
        }
    }
    header("Location: index.php?page=home");
    exit();
}

?>

<?php
$user = null;
if (isLoggedIn()) {
    $user = getCurrentUser($pdo);
}
?>

<header class="site-header">
    <div id="signinModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Войти</h2>
                <span class="close"></span>
            </div>
            <form id="signinForm" name="signinForm" method="post" action="header.php">
                <input type="email" name="email" placeholder="Почта" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit" name="signinForm">Войти</button>
                <div>
                    <span class="span">
                        <div>Нет аккаунта?</div>
                        <button class="default-button" onclick="openModal('signupModal')" type="button">Зарегистрируйтесь</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div id="signupModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Зарегистрироваться</h2>
                <span class="close"></span>
            </div>
            <form id="signupForm" method="post" action="index.php">
                <input type="text" name="username" placeholder="Имя пользователя" required>
                <input type="email" name="email" placeholder="Почта" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
                <button type="submit" name="signupForm">Зарегистрироваться</button>
                <div>
                    <span class="span">
                        <div>Есть аккаунт?</div>
                        <button class="default-button" onclick="openModal('signinModal')" type="button">Войдите</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header-inner">
            <div class="header-left">
                <div class="logo">
                    <a href="index.php?page=home">
                        <img src="images/logo/logo.png" alt="GameStudio" class="logo-img">
                    </a>
                </div>
                <nav>
                    <ul class="nav-inner">
                        <div class="main-menu main-menu-left">
                            <li><a href="#catalog">Каталог</a></li>
                            <li><a href="#about-us">О нас</a></li>
                        </div>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="search">
                    <input type="text" name="search" id="" placeholder="поиск...">
                    <a href="">
                        <img src="images/icons/search.png" alt="">
                    </a>
                </div>

                <div class="horizontal-line"></div>

                <div class="main-menu main-menu-right">
                    <div>
                        <?php if (isLoggedIn() && $user): ?>
                            <a href="index.php?page=profile" class="profile">
                                <img src="images/icons/user.png" alt="">
                                <div>
                                    <li><?= htmlspecialchars($user['username']) ?></li>
                                    <li><?= htmlspecialchars($user['role']) ?></li>
                                </div>
                            </a>
                        <?php else: ?>
                            <li><button class="default-button" onclick="openModal('signinModal')">Вход</button></li>
                            <li><button class="default-button" onclick="openModal('signupModal')">Регистрация</button></li>
                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <div class="burger-button" id="burger-button">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="burger-menu">
                <ul class="nav-inner">
                    <div class="main-menu main-menu-right">
                        <?php if (isLoggedIn() && $user): ?>
                            <a href="index.php?page=profile" class="profile">
                                <img src="images/icons/user.png" alt="">
                                <div>
                                    <li><?= htmlspecialchars($user['username']) ?></li>
                                    <li><?= htmlspecialchars($user['role']) ?></li>
                                </div>
                            </a>
                        <?php else: ?>
                            <li><button class="default-button" onclick="openModal('signinModal')">Вход</button></li>
                            <li><button class="default-button" onclick="openModal('signupModal')">Регистрация</button></li>
                        <?php endif; ?>

                    </div>
                    <form id="header-search-form" method="get" action="index.php" autocomplete="off">
                        <input type="hidden" name="page" value="home">
                        <input type="text" name="search" id="searchInput" placeholder="поиск..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" autocomplete="off">
                        <div id="search-hints" style="background:#fff; border:1px solid #ccc; display:none; position:absolute; z-index:999; width:100%;"></div>
                        <button type="submit" style="background:none; border:none;">
                            <img src="images/icons/search.png" alt="">
                        </button>
                    </form>

                    <div class="main-menu main-menu-left">
                        <li><a href="#catalog">Каталог</a></li>
                        <li><a href="#about-us">О нас</a></li>
                    </div>
                </ul>
            </div>

        </div>
</header>