<?php
require_once __DIR__ . '/db.php';
?>
<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <div class="header-left">
                <div class="logo">
                    <a href="index.php?page=home">
                        <img src="images/logo/logo.png" alt="GameStudio" class="logo-img">
                    </a>
                </div>
                <nav>
                    <ul class="nav-inner">
                        <div class="main-menu main-menu-left">
                            <li><a href="index.php?page=courses">Каталог</a></li>
                            <li><a href="index.php?page=about">О нас</a></li>
                            <li><a href="index.php?page=contact">Контакты</a></li>
                        </div>


                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="search">
                    <input type="text" name="search" id="" placeholder="поиск...">
                    <a href="">
                        <img src="images/icons/search.png" alt="">
                    </a>
                </div>

                <div class="horizontal-line"></div>

                <div class="main-menu main-menu-right">
                    <div>
                        <?php if (isLoggedIn()): ?>
                                <a href="index.php?page=profile" class="profile">
                                    <img src="images/icons/user.png" alt="">
                                    <div>
                                        <li>Пользователь</li>
                                        <li>Описание</li>
                                    </div>
                                </a>

                        <?php else: ?>
                            <li><a href="index.php?page=login">Вход</a></li>
                            <li><a href="index.php?page=register">Регистрация</a></li>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</header>