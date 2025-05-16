/* Управление модальными окнами */
document.addEventListener('DOMContentLoaded', function () {
  // Обработка бургер-меню
  const burgerButton = document.getElementById("burger-button");
  const burgerMenu = document.querySelector(".burger-menu");

  if (burgerButton && burgerMenu) {
    burgerButton.addEventListener("click", function () {
      burgerButton.classList.toggle("active-burger");
      burgerMenu.classList.toggle("active-burger-menu");

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
  }

  // Обработка фильтров на главной странице
  const filterButtons = document.querySelectorAll('.filter-button');
  if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();

        // Убираем класс выбранного фильтра у всех кнопок
        filterButtons.forEach(btn => {
          btn.classList.remove('filter-selected');
        });

        // Добавляем класс выбранного фильтра текущей кнопке
        this.classList.add('filter-selected');

        // Получаем значение фильтра
        const filter = this.textContent.trim();

        // Фильтрация курсов
        if (filter === 'все курсы') {
          window.location.href = 'index.php?page=home';
        } else if (filter === 'junior') {
          window.location.href = 'index.php?page=home&level=beginner';
        } else if (filter === 'middle') {
          window.location.href = 'index.php?page=home&level=intermediate';
        } else if (filter === 'senior') {
          window.location.href = 'index.php?page=home&level=advanced';
        }
      });
    });
  }

  // Обработка поиска
  const searchInputs = document.querySelectorAll('.search input');
  if (searchInputs.length > 0) {
    searchInputs.forEach(input => {
      input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          const searchQuery = this.value.trim();
          if (searchQuery) {
            window.location.href = `index.php?page=home&search=${encodeURIComponent(searchQuery)}`;
          }
        }
      });
    });
  }

  // Модальные окна
  const modalCloseButtons = document.querySelectorAll('.modal .close');
  if (modalCloseButtons.length > 0) {
    modalCloseButtons.forEach(button => {
      button.addEventListener('click', function () {
        const modal = this.closest('.modal');
        if (modal) {
          modal.style.display = 'none';
          enableScrolling();
        }
      });
    });
  }

  // Закрытие модального окна при клике вне его
  window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal')) {
      event.target.style.display = 'none';
      enableScrolling();
    }
  });

  // Аккордеон для FAQ
  const accordions = document.querySelectorAll('.accordion');
  if (accordions.length > 0) {
    accordions.forEach(accordion => {
      accordion.addEventListener('click', function () {
        this.classList.toggle('active');
        const panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      });
    });
  }

  // Слайдер на странице курса
  initializeSliders();

  // Админ-панель: обработчики событий для CRUD операций с курсами
  initializeAdminPanelHandlers();
});

// Инициализация слайдеров
function initializeSliders() {
  // Слайдер курсов
  const courseSlider = document.getElementById('courseSlider');
  if (courseSlider) {
    const slides = courseSlider.querySelectorAll('.slide');
    const dots = courseSlider.querySelectorAll('.slider-dots span');
    let currentSlide = 0;
    let slideInterval;

    // Функция для показа текущего слайда
    function showSlide(n) {
      slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === n);
      });

      if (dots.length > 0) {
        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === n);
        });
      }
      currentSlide = n;
    }

    // Функция для автоматического переключения слайдов
    function startSlideshow() {
      slideInterval = setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }, 4000);
    }

    // Обработчик клика по точкам
    if (dots.length > 0) {
      dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
          clearInterval(slideInterval);
          showSlide(i);
          startSlideshow();
        });
      });
    }

    // Запуск слайдшоу
    startSlideshow();
  }

  // Слайдер отзывов
  const reviewsTrack = document.getElementById('reviewsTrack');
  if (reviewsTrack) {
    const prevButton = document.getElementById('revPrev');
    const nextButton = document.getElementById('revNext');
    const cards = reviewsTrack.children;
    let currentPosition = 0;
    const cardGap = 24;

    function updateReviewsPosition() {
      if (cards.length > 0) {
        const cardWidth = cards[0].offsetWidth + cardGap;
        reviewsTrack.style.transform = `translateX(-${currentPosition * cardWidth}px)`;

        // Обновление состояния кнопок
        if (prevButton && nextButton) {
          prevButton.classList.toggle('not_active', currentPosition === 0);

          const visibleCards = getVisibleCardsCount();
          nextButton.classList.toggle('not_active', currentPosition >= cards.length - visibleCards);
        }
      }
    }

    function getVisibleCardsCount() {
      const wrapperWidth = reviewsTrack.parentElement.offsetWidth;
      const cardWidth = cards[0].offsetWidth + cardGap;
      return Math.floor(wrapperWidth / cardWidth);
    }

    if (prevButton) {
      prevButton.addEventListener('click', () => {
        if (currentPosition > 0) {
          currentPosition--;
          updateReviewsPosition();
        }
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', () => {
        const visibleCards = getVisibleCardsCount();
        if (currentPosition < cards.length - visibleCards) {
          currentPosition++;
          updateReviewsPosition();
        }
      });
    }

    // Инициализация начального положения
    updateReviewsPosition();

    // Обновление при изменении размера окна
    window.addEventListener('resize', updateReviewsPosition);
  }
}

// Инициализация обработчиков для админ-панели
function initializeAdminPanelHandlers() {
  // Обработчик формы добавления курса
  const addCourseForm = document.getElementById('addProductForm');
  if (addCourseForm) {
    addCourseForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('handlers/add_course_handler.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Курс успешно добавлен!');
            const modal = document.getElementById('addProductModal');
            if (modal) {
              modal.style.display = 'none';
            }
            location.reload();
          } else {
            alert('Ошибка: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Ошибка:', error);
          alert('Произошла ошибка при отправке данных.');
        });
    });
  }

  // Обработчик кнопок редактирования курса
  const editCourseButtons = document.querySelectorAll('.edit-course');
  if (editCourseButtons.length > 0) {
    editCourseButtons.forEach(button => {
      button.addEventListener('click', function () {
        const courseId = this.dataset.courseId;

        fetch(`handlers/get_course_handler.php?id=${courseId}`)
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              alert(data.error);
            } else {
              document.getElementById('edit-course-id').value = courseId;
              document.getElementById('edit-title').value = data.title;
              document.getElementById('edit-description').value = data.description;
              document.getElementById('edit-price').value = data.price;
              document.getElementById('edit-lessons_count').value = data.lessons_count;
              document.getElementById('edit-level').value = data.level;

              const modal = document.getElementById('editProductModal');
              if (modal) {
                modal.style.display = 'block';
                disableScrolling();
              }
            }
          });
      });
    });
  }

  // Обработчик формы редактирования курса
  const editCourseForm = document.getElementById('editProductForm');
  if (editCourseForm) {
    editCourseForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('handlers/update_course_handler.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Курс успешно обновлен!');
            const modal = document.getElementById('editProductModal');
            if (modal) {
              modal.style.display = 'none';
            }
            location.reload();
          } else {
            alert('Ошибка: ' + data.message);
          }
        });
    });
  }

  // Обработчик кнопок удаления курса
  const deleteCourseButtons = document.querySelectorAll('.delete-course');
  if (deleteCourseButtons.length > 0) {
    deleteCourseButtons.forEach(button => {
      button.addEventListener('click', function () {
        if (confirm('Вы уверены, что хотите удалить курс?')) {
          const courseId = this.dataset.courseId;

          const formData = new FormData();
          formData.append('id', courseId);

          fetch('handlers/delete_course_handler.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Курс успешно удален!');
                location.reload();
              } else {
                alert('Ошибка: ' + data.message);
              }
            });
        }
      });
    });
  }

  // Обработчик кнопок редактирования пользователя
  const editUserButtons = document.querySelectorAll('.edit-user');
  if (editUserButtons.length > 0) {
    editUserButtons.forEach(button => {
      button.addEventListener('click', function () {
        const userId = this.dataset.userId;

        fetch(`handlers/get_user_handler.php?id=${userId}`)
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              alert(data.error);
            } else {
              document.getElementById('edit-user-id').value = userId;
              document.getElementById('edit-username').value = data.username;
              document.getElementById('edit-email').value = data.email;
              document.getElementById('edit-role').value = data.role;
              document.getElementById('edit-is_active').checked = data.is_active == 1;

              const modal = document.getElementById('editUserModal');
              if (modal) {
                modal.style.display = 'block';
                disableScrolling();
              }
            }
          });
      });
    });
  }

  // Обработчик формы редактирования пользователя
  const editUserForm = document.getElementById('editUserForm');
  if (editUserForm) {
    editUserForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('handlers/update_user_handler.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Пользователь успешно обновлен!');
            const modal = document.getElementById('editUserModal');
            if (modal) {
              modal.style.display = 'none';
            }
            location.reload();
          } else {
            alert('Ошибка: ' + data.message);
          }
        });
    });
  }

  // Обработчик формы отправки отзыва
  const reviewForm = document.getElementById('review-form');
  if (reviewForm) {
    reviewForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('handlers/review_handler.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Отзыв успешно добавлен!');
            location.reload();
          } else {
            alert('Ошибка: ' + data.message);
          }
        });
    });
  }
}

// Вспомогательные функции
function openModal(nameOfModal) {
  const modals = document.getElementsByClassName('modal');
  for (let i = 0; i < modals.length; i++) {
    modals[i].style.display = "none";
  }
  const modal = document.getElementById(nameOfModal);
  if (modal) {
    modal.style.display = "block";
    disableScrolling();
  }
}

function disableScrolling() {
  document.body.style.overflow = "hidden";
}

function enableScrolling() {
  document.body.style.overflow = "auto";
}

