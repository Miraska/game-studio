<?php
$course = [
  'title'   => 'Unity – Junior',
  'lessons' => 6,
  'rating'  => 198,
  'level'   => 'средний',
  'price'   => 3500,
  'slides'  => [
    '1.png',
    '2.jpeg',
    '3.webp',
    '4.jpeg',
    '5.jpeg',
  ],
  'text' => [
    'Курс «Junior Unity»<br>Этот курс предназначен для начинающих разработчиков игр, которые хотят сделать первые шаги в мире создания интерактивного контента с помощью движка Unity. В рамках курса участники изучат базовые принципы работы с Unity, освоят С#, получат практические навыки в создании 2D и 3D‑игр.',
    'Цель курса:<br>Сформировать прочную базу знаний, необходимую для дальнейшего развития в геймдеве. После завершения программы вы сможете уверенно создавать первые проекты, продолжить обучение на более продвинутых модулях и начать профессиональную карьеру.',
  ],
];

$reviews = [
  [
    'name'   => 'Альберт',
    'avatar' => 'albert.png',
    'text'   => 'Вчера был мой первый урок – всё понравилось! Преподаватели вежливые и добрые, всё понятно объяснили.',
  ],
  [
    'name'   => 'Ибрагим',
    'avatar' => 'ibragim.png',
    'text'   => 'Насыщенный курс, много практики и полезных материалов. Пока всё устраивает!',
  ],
  [
    'name'   => 'Мирас',
    'avatar' => 'miras.png',
    'text'   => 'Материал подан доступно, даже новичок быстро включается в работу. Рекомендую.',
  ],
  [
    'name'   => 'Олуся',
    'avatar' => 'olesya.png',
    'text'   => 'Особенно понравились домашние задания и оперативная обратная связь преподавателя.',
  ],
];
?>
<section class="lesson-section">
  <div class="slider-wrapper">
    <div class="slider" id="courseSlider">
      <?php foreach ($course['slides'] as $i => $src): ?>
        <div class="slide<?= $i === 0 ? ' active' : '' ?>">
          <img src="images/courses/<?= htmlspecialchars($src) ?>" alt="Слайд <?= $i + 1 ?>">
        </div>
      <?php endforeach; ?>

      <div class="slider-dots">
        <?php foreach ($course['slides'] as $i => $_): ?>
          <span data-slide="<?= $i ?>" <?= $i === 0 ? 'class="active"' : '' ?>></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="info">
    <div class="top-info">
      <h1><?= htmlspecialchars($course['title']) ?></h1>
      <div class="meta">
        <div><img src="images/icons/book.png" alt="icon"> урок: <?= $course['lessons'] ?></div>
        <div><img src="images/icons/user_small.png" alt="icon"> рейтинг: <?= $course['rating'] ?></div>
        <div><img src="images/icons/rating.png" alt="icon"> <?= htmlspecialchars($course['level']) ?></div>
      </div>
    </div>

    <div class="description">
      <?php foreach ($course['text'] as $p): ?>
        <p style="font-weight: 500;"><?= $p ?></p>
      <?php endforeach; ?>
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
            <img src="images/about_us/<?= htmlspecialchars($rev['avatar']) ?>" alt="<?= htmlspecialchars($rev['name']) ?>">
            <div class="review-name"><?= htmlspecialchars($rev['name']) ?></div>
          </div>
          <div class="review-text"><?= htmlspecialchars($rev['text']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <a href="#" class="btn-secondary">оставить отзыв</a>
</section>

<script>
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

    function getVisibleCards() {
      const wrapperWidth = document.querySelector('.reviews-wrapper').offsetWidth;
      const cardWidth = cards[0].offsetWidth + gap;
      return Math.floor(wrapperWidth / cardWidth);
    }

    prev.addEventListener('click', () => {
      current = Math.max(0, current - 1);
      update();
    });

    next.addEventListener('click', () => {
      const visible = getVisibleCards();
      current = Math.min(cards.length - 1 - visible, current + 1);
      update();
    });

    window.addEventListener('resize', update);
    update();
  })();
</script>