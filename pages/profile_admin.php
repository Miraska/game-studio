<?php
// Файл: pages/profile.php
// if (!isLoggedIn()) {
//     echo "<p>Для просмотра профиля требуется авторизация.</p>";
//     return;
// }


?>

<section class="profile-section">
    <!-- Modal Container -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Добавить курс</h2>
                <span class="close"></span>
            </div>

            <form id="addProductForm" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Название" required>
                <textarea name="description" placeholder="Описание" required></textarea>
                <input type="number" name="price" placeholder="Цена" step="0.01" required>
                <input type="number" name="lessons" placeholder="Кол-во уроков" required>
                <label class="file">
                    <input type="file" id="file" aria-label="File browser example" name="files[]" multiple>
                    <span class="file-custom"></span>
                </label>
                <button type="submit">Добавить</button>
            </form>
        </div>
    </div>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Изменить пользователя</h2>
                <span class="close"></span>
            </div>

            <form id="editUserForm" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Имя">
                <input type="email" placeholder="Почта"></input>
                <input type="password" name="price" placeholder="Пароль" step="0.01">
                <select type="" name="lessons" placeholder="Роль">
                    <option value="admin">Админ</option>
                    <option value="user">Пользователь</option>
                    <option value="teacher">Преподаватель</option>
                </select>
                <button type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-top">
                <h2>Изменить курс</h2>
                <span class="close"></span>
            </div>

            <form id="editUserForm" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Название" required>
                <textarea name="description" placeholder="Описание" required></textarea>
                <input type="number" name="price" placeholder="Цена" step="0.01" required>
                <input type="number" name="lessons" placeholder="Кол-во уроков" required>
                <label class="file">
                    <input type="file" id="file" aria-label="File browser example" name="files[]" multiple>
                    <span class="file-custom"></span>
                </label>
                <button type="submit">Добавить</button>
            </form>
        </div>
    </div>

    <div class="profile-left">
        <div>
            <img src="images/icons/user_profile.png" alt="">
        </div>
        <div class="profile-left-inner">
            <p>Админ</p>
            <p id="second">админ</p>
            <p id="third">admin.1010@gmail.com</p>
            <div>
                <a href="index.php?page=" class="btn-primary"
                    style="background-color: #9E5CF2; color: #fff; padding: 6px 20px; border-radius: 8px;">Выйти
                </a>
            </div>
        </div>
    </div>

    <div class="profile-right">
        <h1>Админ панель</h1>

        <div class="tables">
            <!-- Управление курсами -->
            <h2>Управление курсами</h2>
            <div class="table-container">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Unity - Junior</td>
                            <td>4500 руб</td>
                            <td><button class="default-button-table" onclick="openModal('editProductModal')">Редактировать</button> | <button class="default-button-table">Удалить</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Unity - Senior</td>
                            <td>5000 руб</td>
                            <td><button class="default-button-table" onclick="openModal('editProductModal')">Редактировать</button> | <button class="default-button-table">Удалить</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn-primary" onclick="openModal('addProductModal')">добавить курс</button>


            <!-- Управление пользователями -->
            <h2 class="mt-2">Управление пользователями</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Иван</td>
                            <td>user@example.com</td>
                            <td>Пользователь</td>
                            <td><button class="default-button-table" onclick="openModal('editUserModal')">Изменить пользователя</button> | <button class="default-button-table">Заблокировать</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Мария</td>
                            <td>user@example.com</td>
                            <td>Пользователь</td>
                            <td><button class="default-button-table" onclick="openModal('editUserModal')">Изменить пользователя</button> | <button class="default-button-table">Заблокировать</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Управление заказами -->
            <h2 class="mt-2">Управление заказами</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID заказа</th>
                            <th>Название</th>
                            <th>Пользователь</th>
                            <th>Дата</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>101</td>
                            <td>Unity - Middle</td>
                            <td>пользователь 1</td>
                            <td>1.01.2024</td>
                            <td><button class="default-button-table" onclick="openModal('')">Приянть</button> | <button class="default-button-table">Заблокировать</button></td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td>Unity - Senior</td>
                            <td>пользователь 2</td>
                            <td>1.01.2024</td>
                            <td><button class="default-button-table" onclick="openModal('')">Приянть</button> | <button class="default-button-table">Заблокировать</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<script>
    let modal;
    var span = document.getElementsByClassName("close");

    function openModal(nameOfModal) {
        console.log(nameOfModal);
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