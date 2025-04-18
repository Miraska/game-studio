<article class="card">
  <img class="card-img" src="<?= $c['image'] ?>" alt="<?= htmlspecialchars($c['title']) ?>">
  <div class="average-card">
    <h4><?= htmlspecialchars($c['title']) ?></h4>
    <div class="average-card-inner">
      <div class="icon-text-average-card-inner">
        <img src="images/icons/book.png" alt=""><span>урок: <?= $c['lessons_cnt'] ?></span>
      </div>
      <div class="icon-text-average-card-inner">
        <img src="images/icons/rating.png" alt=""><span><?= ucfirst($c['level']) ?></span>
      </div>
    </div>
  </div>
  <a href="index.php?page=course&id=<?= $c['id'] ?>" class="btn-primary">Вперёд <i class="arrow right"></i></a>
</article>
