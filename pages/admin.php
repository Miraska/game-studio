<?php
// Файл: pages/admin.php
if (!isAdmin()) {
    echo "<p>У вас нет прав доступа к этой странице.</p>";
    return;
}

// Пример выборки пользователей
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Админ-панель</h2>

<div class="admin-section">
  <h3>Список пользователей</h3>
  <table class="admin-table">
    <tr>
      <th>ID</th>
      <th>Имя</th>
      <th>Email</th>
      <th>Роль</th>
      <th>Дата регистрации</th>
    </tr>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td><?= $u['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<!-- Аналогично можно выводить/редактировать курсы, уроки, комментарии и т.д. -->
