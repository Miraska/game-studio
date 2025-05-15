<?php
// if (!isLoggedIn()) {
//     echo "<p>Для просмотра профиля требуется авторизация.</p>";
//     return;
// }


?>

<section class="profile-section">
  <div class="profile-left">
    <div>
      <img src="images/icons/user_profile.png" alt="">
    </div>
    <div class="profile-left-inner">
      <p>Miras</p>
      <p id="second">ученик</p>
      <p id="third">miraska.007@gmail.com</p>
      <div>
        <a href="index.php?page=" class="btn-primary"
          style="background-color: #9E5CF2; color: #fff; padding: 6px 20px; border-radius: 8px;">Выйти
        </a>
      </div>
    </div>
  </div>

  <div class="profile-right">
    <h3>Мои курсы</h3>
    <div class="cards">

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

      </div>

      <div class="card">
        <img src="images/courses/4.jpeg" alt="course" class="card-img img">

        <div class="average-card">
          <h4>Изучение unity - senior </h4>

          <div class="average-card-inner">
            <div class="icon-text-average-card-inner">
              <img src="images/icons/book.png" alt="icon">
              <span>Урок : 23</span>
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

      </div>
    </div>
    <a href="" class="btn-primary">Раскрыть все</a>
  </div>


</section>