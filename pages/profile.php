<?php
// Файл: pages/profile.php
if (!isLoggedIn()) {
    echo "<p>Для просмотра профиля требуется авторизация.</p>";
    return;
}
$user = getCurrentUser();
?>
<h2>Личный кабинет</h2>
<div class="profile-info">
  <p><strong>Логин:</strong> <?= htmlspecialchars($user['username']) ?></p>
  <p><strong>Роль:</strong> <?= htmlspecialchars($user['role']) ?></p>
</div>
<div class="profile-courses">
  <h3>Мои курсы</h3>
  <p>Здесь можно вывести курсы, на которые пользователь подписан, или результаты тестов.</p>
</div>
