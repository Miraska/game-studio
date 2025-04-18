<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Все поля обязательны для заполнения.";
    } else {
        $res = registerUser($pdo, $username, $email, $password);
        if ($res === true) {
            $success = true;
        } else {
            $errors[] = $res;
        }
    }
}
?>
<h2>Регистрация</h2>
<?php if ($success): ?>
  <div class="success-msg">Регистрация прошла успешно! <a href="index.php?page=login">Войти</a></div>
<?php else: ?>
  <?php if (!empty($errors)): ?>
    <div class="error-block">
      <?php foreach ($errors as $err): ?>
        <p><?= htmlspecialchars($err) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="post" class="form-auth">
    <label for="username">Имя пользователя:</label>
    <input type="text" id="username" name="username">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email">

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password">

    <button type="submit" class="btn-primary">Зарегистрироваться</button>
  </form>
<?php endif; ?>
