// Файл: public/js/main.js

document.addEventListener('DOMContentLoaded', () => {
  console.log("GameStudio scripts loaded.");

  // Пример плавной прокрутки к якорю (если нужно)
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
});


/* Бургер‑меню */
const burger = document.getElementById('burger');
const mainNav = document.getElementById('main-nav');

burger?.addEventListener('click', () => {
  burger.classList.toggle('open');
  mainNav.classList.toggle('open');
});

/* Закрыть меню по клику вне */
document.addEventListener('click', e => {
  if (!mainNav.contains(e.target) && !burger.contains(e.target)) {
    burger.classList.remove('open');
    mainNav.classList.remove('open');
  }
});
