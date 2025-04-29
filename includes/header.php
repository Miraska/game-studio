<?php
require_once __DIR__ . '/db.php';
?>
<header class="site-header">
    <div id="signinModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Войти</h2>
                <span class="close"></span>
            </div>

            <form id="signinForm" method="post" enctype="multipart/form-data">
                <input type="email" name="email" placeholder="Почта">
                <input type="password" name="price" placeholder="Пароль" step="0.01">
                <button type="submit">Войти</button>
                <div>
                    <span class="span">
                        <div>Нет аккаунта?</div> <button class="default-button" onclick="openModal('signupModal')" type="button">Зарегистрируйтесь</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div id="signupModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Зарегистрироваться</h2>
                <span class="close"></span>
            </div>

            <form id="signupForm" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Имя">
                <input type="email" name="email" placeholder="Почта">
                <input type="password" name="price" placeholder="Пароль" step="0.01">
                <button type="submit">Зарегистрироваться</button>
                <div>
                    <span class="span">
                        <div>Есть аккаунт?</div> <button class="default-button" onclick="openModal('signinModal')" type="button">Войдите</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

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
                            <li><a href="#catalog">Каталог</a></li>
                            <li><a href="#about-us">О нас</a></li>
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
                            <li><button class="default-button" onclick="openModal('signinModal')">Вход</button></li>
                            <li><button class="default-button" onclick="openModal('signupModal')">Регистрация</button></li>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <div class="burger-button" id="burger-button">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="burger-menu">
                <ul class="nav-inner">
                    <div class="main-menu main-menu-right">
                        <?php if (isLoggedIn()): ?>
                            <a href="index.php?page=profile" class="profile">
                                <img src="images/icons/user.png" alt="">
                                <div>
                                    <li>Пользователь</li>
                                    <li>Описание</li>
                                </div>
                            </a>

                        <?php else: ?>
                            <li><button class="default-button" onclick="openModal('signinModal')">Вход</button></li>
                            <li><button class="default-button" onclick="openModal('signupModal')">Регистрация</button></li>
                        <?php endif; ?>
                    </div>
                    <div class="search">
                        <input type="text" name="search" id="" placeholder="поиск...">
                        <a href="">
                            <img src="images/icons/search.png" alt="">
                        </a>
                    </div>
                    <div class="main-menu main-menu-left">
                        <li><a href="#catalog">Каталог</a></li>
                        <li><a href="#about-us">О нас</a></li>
                    </div>
                </ul>
            </div>

        </div>
</header>

<script>
    let modal;
    var span = document.getElementsByClassName("close");
    const burgerButton = document.getElementById("burger-button");
    const navMenus = document.querySelectorAll(".nav-inner li a");
    const buttonMenus = document.querySelectorAll(".main-menu-right li button");

    for (let i = 0; i < navMenus.length; i++) {
        navMenus[i].addEventListener("click", function() {
            burgerButton.classList.remove("active-burger");
            document.querySelector(".burger-menu").classList.remove("active-burger-menu");
            burgerButton.style.transform = "rotate(0deg)";
            burgerButton.style.transition = "0.5s";
            enableScrolling();
        });
    }

    for (let i = 0; i < buttonMenus.length; i++) {
        buttonMenus[i].addEventListener("click", function() {
            burgerButton.classList.remove("active-burger");
            document.querySelector(".burger-menu").classList.remove("active-burger-menu");
            burgerButton.style.transform = "rotate(0deg)";
            burgerButton.style.transition = "0.5s";
            enableScrolling();
        });
    }

    burgerButton.addEventListener("click", function() {
        burgerButton.classList.toggle("active-burger");

        document.querySelector(".burger-menu").classList.toggle("active-burger-menu");
        document.querySelector(".burger-menu").style.transition = "0.5s";




        if (burgerButton.classList.contains("active-burger")) {
            burgerButton.style.transform = "rotate(90deg)";
            burgerButton.style.transition = "0.5s";
            disableScrolling();

        } else {
            burgerButton.style.transform = "rotate(0deg)";
            burgerButton.style.transition = "0.5s";
            enableScrolling();
        }
    });

    function openModal(nameOfModal) {
        modals = document.getElementsByClassName('modal');
        for (let i = 0; i < modals.length; i++) {
            modals[i].style.display = "none";
        }
        modal = document.getElementById(nameOfModal);
        modal.style.display = "block";
        disableScrolling();

    }


    for (let i = 0; i < span.length; i++) {
        span[i].onclick = function() {
            modal.style.display = "none";
            enableScrolling();
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            enableScrolling();
        }
    }

    function disableScrolling() {
        document.body.style.overflow = "hidden";
    }

    function enableScrolling() {
        document.body.style.overflow = "auto";
    }

    document.getElementById("addProductForm").addEventListener("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch("add_product.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Товар успешно добавлен!");
                    modal.style.display = "none";
                } else {
                    alert("Ошибка при добавлении товара: " + data.message);
                }
            })
            .catch(error => {
                console.error("Ошибка:", error);
                alert("Произошла ошибка при отправке данных.");
            });
    });
</script>