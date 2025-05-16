<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: index.php?page=home");
    exit();
}

$user = getCurrentUser($pdo);
$courses = getUserCourses($pdo, $_SESSION['user_id']);
?>

<section class="profile-section">
    <div class="profile-left">
        <div><img src="images/icons/user_profile.png" alt=""></div>
        <div class="profile-left-inner">
            <p><?= escape($user['username']) ?></p>
            <p id="second"><?= escape($user['role']) ?></p>
            <p id="third"><?= escape($user['email']) ?></p>
            <div>
                <a href="logout.php" class="btn-primary" style="background-color: #9E5CF2; color: #fff; padding: 6px 20px; border-radius: 8px;">Выйти</a>
            </div>
        </div>
    </div>
    <div class="profile-right">
        <h3>Мои курсы</h3>
        <div class="cards">
            <?php foreach ($courses as $course): ?>
                <div class="card">
                    <img src="images/courses/<?= escape($course['image_path']) ?>" alt="<?= escape($course['title']) ?>" class="card-img img">
                    <div class="average-card">
                        <h4><?= escape($course['title']) ?></h4>
                        <div class="average-card-inner">
                            <div class="icon-text-average-card-inner">
                                <img src="images/icons/book.png" alt="icon">
                                <span>Урок: <?= $course['lessons_count'] ?></span>
                            </div>
                            <div class="icon-text-average-card-inner">
                                <img src="images/icons/rating.png" alt="icon">
                                <span><?= ucfirst($course['level']) ?></span>
                            </div>
                        </div>
                    </div>
                    <a href="index.php?page=lesson&id=<?= $course['id'] ?>" class="btn-primary">Вперёд <i class="arrow right"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>