<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
if (!isLoggedIn()) {
    echo "<p>Для просмотра курса требуется авторизация.</p>";
    return;
}

$course = [
  'title'   => 'Unity – Junior',
  'lessons' => 6,
  'rating'  => 198,
  'level'   => 'средний',
  'slides'  => [
    '1.png',
    '2.jpeg',
    '3.webp',
    '4.jpeg',
    '5.jpeg',
  ],
  'notes'   => [
    'Конспект лекции 1.pdf',
    'Конспект лекции 2.pdf',
    'Конспект лекции 3.pdf',
    'Конспект лекции 4.pdf',
    'Конспект лекции 5.pdf',
    'Конспект лекции 6.pdf',
  ],
  'assignments' => [
    'Задание 1: Создать сцену',
    'Задание 2: Добавить персонажа',
    'Задание 3: Реализовать движение',
    'Задание 4: Добавить препятствия',
    'Задание 5: Настроить камеру',
    'Задание 6: Опубликовать проект',
  ],
  'text' => [
    'Курс «Junior Unity»<br>Этот курс предназначен для разработчиков игр уровня Junior, уже знакомых с основами, и желающих углубить навыки в движке Unity.',
    'В рамках курса вы получите подробные конспекты к каждому уроку, доступ к слайдам, видеоразборы и практические задания с проверкой.',
  ],
];

$reviews = [
  [
    'name'   => 'Альберт',
    'avatar' => 'albert.png',
    'text'   => 'Вчера был мой первый урок – всё понравилось! Преподаватели вежливые и добрые, всё понятно объяснили.',
  ],
  [
    'name'   => 'Ибрагим',
    'avatar' => 'ibragim.png',
    'text'   => 'Насыщенный курс, много практики и полезных материалов. Пока всё устраивает!',
  ],
  [
    'name'   => 'Мирас',
    'avatar' => 'miras.png',
    'text'   => 'Материал подан доступно, даже новичок быстро включается в работу. Рекомендую.',
  ],
  [
    'name'   => 'Олуся',
    'avatar' => 'olesya.png',
    'text'   => 'Особенно понравились домашние задания и оперативная обратная связь преподавателя.',
  ],
];
?>

<section class="lesson-section">
  <div class="left-info">
    <div class="access-tabs">
      <button class="tab-button active" data-tab="slides">Слайды</button>
      <button class="tab-button" data-tab="notes">Конспекты</button>
      <button class="tab-button" data-tab="assignments">Задания</button>
    </div>

    <div class="tab-content" id="slides">
      <div class="slider-wrapper">
        <div class="slider" id="courseSlider">
          <?php foreach ($course['slides'] as $i => $src): ?>
            <div class="slide<?= $i === 0 ? ' active' : '' ?>">
              <img src="images/courses/<?= htmlspecialchars($src) ?>" alt="Слайд <?= $i + 1 ?>">
            </div>
          <?php endforeach; ?>

          <div class="slider-dots">
            <?php foreach ($course['slides'] as $i => $_): ?>
              <span data-slide="<?= $i ?>" <?= $i === 0 ? ' class="active"' : '' ?>></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-content" id="notes" style="display:none;">
      <ul class="notes-list">
        <?php foreach ($course['notes'] as $note): ?>
          <li><a href="<?= htmlspecialchars($note) ?>"><?= htmlspecialchars($note) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="tab-content" id="assignments" style="display:none;">
      <ul class="assignments-list">
        <?php foreach ($course['assignments'] as $assignment): ?>
          <li><?= htmlspecialchars($assignment) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="info">
    <div class="right-info">
      <div class="top-info">
        <h1><?= htmlspecialchars($course['title']) ?> (куплено)</h1>
        <div class="meta">
          <div><img src="images/icons/book.png" alt="icon"> Уроков: <?= $course['lessons'] ?></div>
          <div><img src="images/icons/user_small.png" alt="icon"> Рейтинг: <?= $course['rating'] ?></div>
          <div><img src="images/icons/rating.png" alt="icon"> Уровень: <?= htmlspecialchars($course['level']) ?></div>
        </div>
      </div>
      <div class="description">
        <?php foreach ($course['text'] as $p): ?>
          <p style="font-weight: 500;"><?= $p ?></p>
        <?php endforeach; ?>
      </div>
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
            <img src="images/about_us/<?= htmlspecialchars($rev['avatar']) ?>" alt="<?= htmlspecialchars($rev['name']) ?>">
            <div class="review-name"><?= htmlspecialchars($rev['name']) ?></div>
          </div>
          <div class="review-text"><?= htmlspecialchars($rev['text']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <a href="#" class="btn-secondary">Оставить отзыв</a>
</section>

<script>
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const tab = btn.dataset.tab;
      document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
      document.getElementById(tab).style.display = 'block';
    });
  });

  (function() {
    const slider = document.getElementById('courseSlider');
    const slides = slider.querySelectorAll('.slide');
    const dots = slider.querySelectorAll('.slider-dots span');
    let idx = 0,
      timer;

    function show(n) {
      slides.forEach((s, i) => s.classList.toggle('active', i === n));
      dots.forEach((d, i) => d.classList.toggle('active', i === n));
      idx = n;
    }

    function next() {
      show((idx + 1) % slides.length);
    }
    dots.forEach(d => d.addEventListener('click', () => {
      show(+d.dataset.slide);
      reset();
    }));

    function reset() {
      clearInterval(timer);
      timer = setInterval(next, 4000);
    }
    reset();
  })();

  (function() {
    const track = document.getElementById('reviewsTrack');
    const prev = document.getElementById('revPrev');
    const next = document.getElementById('revNext');
    const cards = track.children;
    let current = 0;
    const gap = 24;

    function update() {
      const cardWidth = cards[0].offsetWidth + gap;
      track.style.transform = `translateX(-${current * cardWidth}px)`;
    }
    prev.addEventListener('click', () => {
      current = Math.max(0, current - 1);
      update();
    });
    next.addEventListener('click', () => {
      const visible = Math.floor(document.querySelector('.reviews-wrapper').offsetWidth / (cards[0].offsetWidth + gap));
      current = Math.min(cards.length - visible, current + 1);
      update();
    });
    window.addEventListener('resize', update);
    update();
  })();
</script>