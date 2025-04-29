/* Бургер‑меню */
const burger = document.getElementById('burger');
const mainNav = document.getElementById('main-nav');

burger?.addEventListener('click', () => {
  burger.classList.toggle('open');
  mainNav.classList.toggle('open');
});

/* Закрыть меню по клику вне */
// document.addEventListener('click', e => {
//   if (!mainNav.contains(e.target) && !burger.contains(e.target)) {
//     burger.classList.remove('open');
//     mainNav.classList.remove('open');
//   }
// });


// var acc = document.getElementsByClassName("accordion");
// var i;

// for (i = 0; i < acc.length; i++) {
//   acc[i].addEventListener("click", function() {
//     this.classList.toggle("active");
//     var panel = this.nextElementSibling;
//     if (panel.style.maxHeight) {
//       panel.style.maxHeight = null;
//     } else {
//       panel.style.maxHeight = panel.scrollHeight + "px";
//     }
//   });
// }





// // Get the modal
// var modal = document.getElementById("addProductModal");

// // Get the close button
// var span = document.getElementsByClassName("close")[0];

// // Function to open the modal
// function openModal() {
//     console.log("Modal opened");
//     modal.style.display = "block";
// }

// // Close the modal when the user clicks on <span> (x)
// span.onclick = function() {
//     modal.style.display = "none";
// }

// // Close the modal when the user clicks anywhere outside of it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }

// // Handle form submission
// document.getElementById("addProductForm").addEventListener("submit", function(e) {
//     e.preventDefault();
//     var formData = new FormData(this);
//     fetch("add_product.php", {
//             method: "POST",
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 alert("Товар успешно добавлен!");
//                 modal.style.display = "none";
//             } else {
//                 alert("Ошибка при добавлении товара: " + data.message);
//             }
//         })
//         .catch(error => {
//             console.error("Ошибка:", error);
//             alert("Произошла ошибка при отправке данных.");
//         });
// });