<?php
// Файл: pages/instructor.php
if (!isInstructor()) {
    echo "<p>У вас нет прав доступа к этой странице.</p>";
    return;
}

$currentUser = getCurrentUser();

// Пример добавления курса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc  = trim($_POST['description']);
    if (!empty($title) && !empty($desc)) {
        $stmt = $pdo->prepare("INSERT INTO courses (title, description, instructor_id) 
                              VALUES (:t, :d, :i)");
        $stmt->execute([
            't' => $title,
            'd' => $desc,
            'i' => $currentUser['id']
        ]);
        echo "<p class='success-msg'>Курс успешно добавлен!</p>";
    } else {
        echo "<p class='error-block'>Пожалуйста, заполните все поля.</p>";
    }
}

// Пример выборки курсов данного преподавателя
$stmt = $pdo->prepare("SELECT * FROM courses WHERE instructor_id = :id");
$stmt->execute(['id' => $currentUser['id']]);
$myCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Панель преподавателя</h2>

<div class="instructor-section">
  <h3>Добавить новый курс</h3>
  <form method="post" class="form-auth">
    <label for="title">Название курса:</label>
    <input type="text" id="title" name="title">

    <label for="description">Описание:</label>
    <textarea id="description" name="description" rows="4"></textarea>

    <button type="submit" class="btn-primary">Добавить курс</button>
  </form>
</div>

<div class="instructor-section">
  <h3>Мои курсы</h3>
  <ul>
    <?php foreach ($myCourses as $course): ?>
      <li>
        <strong><?= htmlspecialchars($course['title']) ?></strong><br>
        <em><?= nl2br(htmlspecialchars($course['description'])) ?></em>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
