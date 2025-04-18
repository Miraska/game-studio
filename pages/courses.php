<?php
// Файл: pages/courses.php
$sql = "SELECT c.*, u.username AS instructor_name
        FROM courses c
        JOIN users u ON c.instructor_id = u.id
        ORDER BY c.created_at DESC";
$stmt = $pdo->query($sql);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Курсы по Unity</h2>
<div class="courses-list">
  <?php foreach ($courses as $course): ?>
    <div class="course-item">
      <?php
      $encodedImg = base64_encode($course['img']);
      ?>
      <img src="data:image/png;base64, <?= $encodedImg ?>" alt="<?= htmlspecialchars($course['title']) ?>">

      <h3><?= htmlspecialchars($course['title']) ?></h3>
      <p class="author">Преподаватель: <?= htmlspecialchars($course['instructor_name']) ?></p>
      <p class="description"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
      <a href="index.php?page=lesson&id=<?= $course['id'] ?>" class="btn-secondary">Подробнее</a>
    </div>
  <?php endforeach; ?>
</div>