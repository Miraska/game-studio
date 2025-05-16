<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$filters = [];
if (isset($_GET['level'])) {
  $filters['level'] = $_GET['level'];
}
$courses = getCourses($pdo, $filters);
$newCourses = array_slice($courses, 0, 4);
$topCourses = array_slice($courses, 0, 2);
?>

<div class="container">
  <div class="banner">
    <div class="left-banner">
      <h2>Ультимативный 2D/3D игровой движок</h2>
      <h1>Давай создавать игры!</h1>
      <h2>Unity - это отличный движок для начинающих, поэтому давай его учить вместе!</h2>
      <a href="#catalog" class="btn-primary">Начать <i class="arrow right"></i></a>
      <img src="images/banner/booked.png" alt="booked">
    </div>
    <div class="right-banner">
      <img src="images/banner/airplane.png" alt="Game Development Airplane" class="airplane-img">
    </div>
  </div>
</div>

<section class="course-section" id="catalog">
  <h2>Найди подходящий курс среди <br><span class="purple">150 предоженных курсов!</span></h2>
  <div class="search">
    <input type="text" id="catalog-search" placeholder="поиск">
    <span>или глянь курсы ниже в каталоге</span>
  </div>

  <div class="new-courses">
    <h3><span class="purple">•</span> НОВЫЕ КУРСЫ</h3>
    <div class="filter">
      <a href="" class="filter-button filter-selected">все курсы</a>
      <a href="" class="filter-button">junior</a>
      <a href="" class="filter-button">middle</a>
      <a href="" class="filter-button">senior</a>
      <a href="" class="filter-button">гейм дизайн</a>
      <img src="images/icons/filter.png" alt="">
    </div>
  </div>

  <div class="cards" id="catalog-cards">
    <?php foreach ($courses as $course): ?>
      <div class="card">
        <img src="images/courses/<?= escape($course['image_path']) ?>" alt="<?= escape($course['title']) ?>" class="card-img img">
        <div class="average-card">
          <h4><?= escape($course['title']) ?></h4>
          <div class="average-card-inner">
            <div class="icon-text-average-card-inner">
              <img src="images/icons/book.png" alt="icon">
              <span>Урок : <?= $course['lessons_count'] ?></span>
            </div>
            <div class="icon-text-average-card-inner">
              <img src="images/icons/user_small.png" alt="icon">
              <span>Рейтинг</span>
            </div>
            <div class="icon-text-average-card-inner">
              <img src="images/icons/rating.png" alt="icon">
              <span><?= escape($course['level']) ?></span>
            </div>
          </div>
        </div>
        <a href="index.php?page=lesson&id=<?= $course['id'] ?>" class="btn-primary">Вперед <i class="arrow right"></i></a>
      </div>
    <?php endforeach; ?>
  </div>

  </div>
</section>

<section class="about-us-section" id="about-us">
  <h3><span class="purple">•</span> О НАС</h3>
  <div class="about-us">
    <div class="about-us-left">
      <h2><span class="purple-gradient">Лучшие</span> Учителя</h2>
      <p>В нашей школе вы сможете найти для себя подходящих преподователей и не только!</p>
      <img src="images/about_us/all-instructors.png" alt="all-instructors">
    </div>
    <div class="about-us-right">
      <div class="inctructors">
        <div class="instructor">
          <img src="images\about_us\albert.png" alt="albert">
          <div class="title">
            <h4>Альберт Назмеев</h4>
            <p>Дизайнер</p>
          </div>
        </div>

        <div class="instructor">
          <img src="images\about_us\miras.png" alt="albert">
          <div class="title">
            <h4>Мирас Сафин</h4>
            <p>SEO</p>
          </div>
        </div>

        <div class="instructor">
          <img src="images\about_us\olesya.png" alt="albert">
          <div class="title">
            <h4>Олеся Хауйруллина</h4>
            <p>Тимлид</p>
          </div>
        </div>

        <div class="instructor">
          <img src="images\about_us\ibragim.png" alt="albert">
          <div class="title">
            <h4>Ибагим Хасибгараев</h4>
            <p>SEO</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="top-courses">
  <div class="top-courses-title">
    <h3><span class="purple">•</span> ТОП КУРСЫ</h3>
    <div class="buttons">
      <a id="revPrev" class="not_active">❮</a>
      <a id="revNext">❯</a>
    </div>
  </div>

  <div class="cards">
    <div class="card">
      <img src="images/courses/1.png" alt="course" class="card-img img">

      <div class="average-card">
        <h4>Изучение unity - junior </h4>

        <div class="average-card-inner">
          <div class="icon-text-average-card-inner">
            <img src="images/icons/book.png" alt="icon">
            <span>Урок : 6</span>
          </div>
          <div class="icon-text-average-card-inner">
            <img src="images/icons/user_small.png" alt="icon">
            <span>Рейтинг</span>
          </div>
          <div class="icon-text-average-card-inner">
            <img src="images/icons/rating.png" alt="icon">
            <span>начинающий</span>
          </div>
        </div>
      </div>

      <a href="index.php?page=lesson" class="btn-primary">Вперед <i class="arrow right"></i></a>
    </div>



    <div class="card">
      <img src="images/courses/2.jpeg" alt="course" class="card-img img">

      <div class="average-card">
        <h4>Изучение unity - middle </h4>

        <div class="average-card-inner">
          <div class="icon-text-average-card-inner">
            <img src="images/icons/book.png" alt="icon">
            <span>Урок : 8</span>
          </div>
          <div class="icon-text-average-card-inner">
            <img src="images/icons/user_small.png" alt="icon">
            <span>Рейтинг</span>
          </div>
          <div class="icon-text-average-card-inner">
            <img src="images/icons/rating.png" alt="icon">
            <span>начинающий</span>
          </div>
        </div>
      </div>

      <a href="index.php?page=lesson" class="btn-primary">Вперед <i class="arrow right"></i></a>
    </div>
  </div>

</section>

<section class="faq">
  <h3 style="text-align: center;"><span class="purple">•</span> FAQ (Часто Задаваемые Вопросы)</h3>

  <div class="faq-inner">
    <div class="faq">
      <button class="accordion">
        Какие курсы стоить смотреть начинающему?
      </button>
      <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>

    <div class="faq">
      <button class="accordion">
        Какой язык программирования лучше изучать для создания игр?</button>
      </button>
      <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>

    <div class="faq">
      <button class="accordion">
        Какой язык программирования лучше изучать для создания игр?</button>
      </button>
      <div class="panel">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
  </div>

</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Каталог фильтр
    const searchInput = document.getElementById('catalog-search');
    const cardsContainer = document.getElementById('catalog-cards');

    if (searchInput) {
      searchInput.addEventListener('input', function() {
        const query = searchInput.value.trim();

        fetch('index.php?api=search_courses&q=' + encodeURIComponent(query))
          .then(r => r.json())
          .then(data => {
            let html = '';
            if (data.length === 0) {
              html = '<div style="padding:20px; text-align:center; color:#9e5cf2;">Ничего не найдено</div>';
            } else {
              data.forEach(course => {
                html += `
      <div class="card">
        <img src="images/courses/${course.image_path}" alt="${course.title}" class="card-img img">
        <div class="average-card">
          <h4>${course.title}</h4>
          <div class="average-card-inner">
            <div class="icon-text-average-card-inner">
              <img src="images/icons/book.png" alt="icon">
              <span>Урок : ${course.lessons_count}</span>
            </div>
            <div class="icon-text-average-card-inner">
              <img src="images/icons/user_small.png" alt="icon">
              <span>Рейтинг</span>
            </div>
            <div class="icon-text-average-card-inner">
              <img src="images/icons/rating.png" alt="icon">
              <span>${course.level}</span>
            </div>
          </div>
        </div>
        <a href="index.php?page=lesson&id=${course.id}" class="btn-primary">Вперед <i class="arrow right"></i></a>
      </div>`;
              });
            }
            cardsContainer.innerHTML = html;
          });
      });
    }
  });
</script>