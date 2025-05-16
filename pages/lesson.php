<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Всегда определяй $course_id из $_GET
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (isLoggedIn() && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
  addReview($pdo, $_SESSION['user_id'], $course_id, $_POST['rating'], $_POST['comment']);
  header("Location: index.php?page=lesson&id=$course_id");
  exit();
}

// Потом загружаешь сам курс и отзывы
$course = getCourseById($pdo, $course_id);

if (!$course) {
  echo '<div class="container"><h2>Курс не найден</h2></div>';
  return;
}

$reviews = getCourseReviews($pdo, $course_id);
?>
<section class="lesson-section">
  <div class="slider-wrapper">
    <div class="slider" id="courseSlider">
      <div class="slide active">
        <img src="images/courses/<?= htmlspecialchars($course['image_path']) ?>" alt="Слайд">
      </div>
      <!-- Можно сделать еще слайды, если у тебя несколько картинок -->
      <div class="slider-dots">
        <span class="active"></span>
      </div>
    </div>
  </div>
  <div class="info">
    <div class="top-info">
      <h1><?= htmlspecialchars($course['title']) ?></h1>
      <div class="meta">
        <div><img src="images/icons/book.png" alt="icon"> урок: <?= $course['lessons_count'] ?></div>
        <div><img src="images/icons/user_small.png" alt="icon"> рейтинг: <?= ($course['rating'] ?? '—') ?></div>
        <div><img src="images/icons/rating.png" alt="icon"> <?= htmlspecialchars($course['level']) ?></div>
      </div>
    </div>
    <div class="description">
      <p style="font-weight: 500;"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
    </div>
    <div class="price">Цена: <?= number_format($course['price'], 0, '', ' ') ?> рублей</div>
    <div>
      <a href="#" class="btn-primary">Купить <i class="arrow right"></i></a>
    </div>
  </div>
</section>
<hr>
<section class="reviews-section">
  <div class="reviews-top">
    <div class="reviews-title">Отзывы Студентов</div>
    <div class="review-nav">
      <button id="revPrev">❮</button>
      <button id="revNext">❯</button>
    </div>
  </div>
  <div class="reviews-wrapper">
    <div class="reviews-track" id="reviewsTrack">
      <?php foreach ($reviews as $rev): ?>
        <div class="review-card">
          <div class="review-head">
            <img src="images/about_us/<?= htmlspecialchars($rev['avatar'] ?? 'user.png') ?>" alt="<?= htmlspecialchars($rev['username']) ?>">
            <div class="review-name"><?= htmlspecialchars($rev['username']) ?></div>
          </div>
          <div class="review-text"><?= htmlspecialchars($rev['comment']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php if (isLoggedIn()): ?>
    <form method="post" action="index.php?page=lesson&id=<?= $course_id ?>" class="review-form">
      <h3>Оставить отзыв</h3>
      <input type="number" name="rating" min="1" max="5" required>
      <textarea name="comment" placeholder="Ваш отзыв"></textarea>
      <div>
        <button type="submit">Оставить отзыв</button>
      </div>
    </form>
  <?php else: ?>
    <p class="container" style="text-align:center;">Пожалуйста, войдите в систему, чтобы оставить отзыв.</p>
  <?php endif; ?>
</section>