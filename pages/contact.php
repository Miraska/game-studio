<?php
// Файл: pages/contact.php

$sent = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $msg   = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($msg)) {
        $errors[] = "Все поля обязательны к заполнению.";
    } else {
        // В реальном проекте: отправка письма на почту админа, запись в БД или CRM
        // Здесь просто имитируем, что сообщение отправлено
        $sent = true;
    }
}
?>

<h2>Контакты</h2>
<p>Если у вас есть вопросы или предложения, свяжитесь с нами через форму ниже:</p>

<?php if ($sent): ?>
  <div class="success-msg">Спасибо за сообщение! Мы ответим вам в ближайшее время.</div>
<?php else: ?>
  <?php if (!empty($errors)): ?>
    <div class="error-block">
      <?php foreach ($errors as $err): ?>
        <p><?= htmlspecialchars($err) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="form-contact">
    <label for="name">Имя:</label>
    <input type="text" id="name" name="name">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email">

    <label for="message">Сообщение:</label>
    <textarea id="message" name="message" rows="5"></textarea>

    <button type="submit" class="btn-primary">Отправить</button>
  </form>
<?php endif; ?>
