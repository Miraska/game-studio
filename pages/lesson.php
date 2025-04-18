<?php
if (!isset($_GET['id'])) {
  echo "<p>Курс не найден.</p>";
  return;
}

$courseId = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT c.*, u.username AS instructor_name 
                       FROM courses c
                       JOIN users u ON c.instructor_id = u.id
                       WHERE c.id = :id");
$stmt->execute(['id' => $courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
  echo "<p>Курс не найден.</p>";
  return;
}
?>

<div class="lesson-container">
  <?php
  $encodedImg = base64_encode($course['img']);
  ?>
  <img src="data:image/png;base64, <?= $encodedImg ?>" alt="<?= htmlspecialchars($course['title']) ?>">
  <h2><?= htmlspecialchars($course['title']) ?></h2>
  <p><strong>Автор:</strong> <?= htmlspecialchars($course['instructor_name']) ?></p>
  <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>

  <h3>Содержание курса (пример)</h3>
  <ul>
    <li>Урок 1: Введение в Unity</li>
    <li>Урок 2: Работа со сценами и объектами</li>
    <li>Урок 3: Скрипты на C# (базовый уровень)</li>
    <li>Урок 4: Взаимодействие с физикой</li>
    <li>Урок 5: UI и управление</li>
    <li>Урок 6: Финальный проект</li>
  </ul>
</div>