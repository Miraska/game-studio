<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (empty($username) || empty($password)) {
        $errors[] = "Введите имя пользователя и пароль.";
    } else {
        $user = loginUser($pdo, $username, $password);

        if ($user) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header("Location: index.php?page=profile");
            exit;
        } else {
            $errors[] = "Неверное имя пользователя или пароль.";
        }
    }
}
?>
<h2>Авторизация</h2>
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

  <label for="password">Пароль:</label>
  <input type="password" id="password" name="password">

  <button type="submit" class="btn-primary">Войти</button>
</form>
