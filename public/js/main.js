// js/main.js

// Обработка модальных окон
document.addEventListener('DOMContentLoaded', function () {
  // Модальные окна
  const modals = document.querySelectorAll('.modal');
  const closeButtons = document.querySelectorAll('.close');

  // Закрытие по крестику
  closeButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      modals.forEach(modal => {
        modal.style.display = 'none';
      });
      enableScrolling();
    });
  });

  // Закрытие по клику на область вне модального окна
  window.addEventListener('click', function (event) {
    modals.forEach(modal => {
      if (event.target === modal) {
        modal.style.display = 'none';
        enableScrolling();
      }
    });
  });

  // Фильтрация курсов
  const filterButtons = document.querySelectorAll('.filter-button');
  const courseCards = document.querySelectorAll('.cards .card');

  filterButtons.forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      // Убираем выделение с других кнопок
      filterButtons.forEach(btn => btn.classList.remove('filter-selected'));
      // Выделяем нажатую кнопку
      this.classList.add('filter-selected');

      const filter = this.textContent.toLowerCase();

      // Если выбраны все курсы, показываем все
      if (filter === 'все курсы') {
        courseCards.forEach(card => {
          card.style.display = 'block';
        });
        return;
      }

      // Иначе фильтруем по уровню
      courseCards.forEach(card => {
        const cardLevel = card.querySelector('.icon-text-average-card-inner:nth-child(3) span').textContent.toLowerCase();
        if (cardLevel.includes(filter)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Поиск по курсам
  const searchInputs = document.querySelectorAll('input[name="search"]');

  searchInputs.forEach(input => {
    input.addEventListener('keyup', function () {
      const searchTerm = this.value.toLowerCase();

      // Если поле поиска пустое, показываем все курсы
      if (searchTerm === '') {
        courseCards.forEach(card => {
          card.style.display = 'block';
        });
        return;
      }

      // Иначе фильтруем по названию
      courseCards.forEach(card => {
        const cardTitle = card.querySelector('h4').textContent.toLowerCase();
        if (cardTitle.includes(searchTerm)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Аккордеон для FAQ
  const accordions = document.querySelectorAll('.accordion');

  accordions.forEach(acc => {
    acc.addEventListener('click', function () {
      this.classList.toggle('active');
      const panel = this.nextElementSibling;

      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + 'px';
      }
    });
  });

  // Слайдер для курса
  const courseSlider = document.getElementById('courseSlider');
  if (courseSlider) {
    const slides = courseSlider.querySelectorAll('.slide');
    const dots = courseSlider.querySelectorAll('.slider-dots span');
    let idx = 0;
    let timer;

    function showSlide(n) {
      slides.forEach((s, i) => s.classList.toggle('active', i === n));
      dots.forEach((d, i) => d.classList.toggle('active', i === n));
      idx = n;
    }

    function nextSlide() {
      showSlide((idx + 1) % slides.length);
    }

    dots.forEach(d => d.addEventListener('click', () => {
      showSlide(+d.dataset.slide);
      resetTimer();
    }));

    function resetTimer() {
      clearInterval(timer);
      timer = setInterval(nextSlide, 4000);
    }

    resetTimer();
  }
});

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