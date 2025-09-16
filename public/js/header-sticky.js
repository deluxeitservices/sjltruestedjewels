// window.addEventListener('scroll', function () {
//     document.querySelectorAll('.header-part').forEach(header => {
//         if (window.scrollY > 50) {
//             header.classList.add('scrolled');
//         } else {
//             header.classList.remove('scrolled');
//         }
//     });
// });


$(document).ready(function () {
    // When the close icon is clicked
    $('.close-menu-btn').click(function () {
        $('#navbarNavDropdown').collapse('hide');
    });
});


window.addEventListener("scroll", function () {
  const header = document.querySelector(".header-part");

  if (window.scrollY > 100) {   // 100px scroll ke baad
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
     
  }
});

// window.addEventListener("scroll", function () {
//   const header = document.querySelector("header-part");

//   if (window.scrollY > 100) {  // 100px scroll ke baad chipkega
//     header.classList.add("scrolled");
//   } else {
//     header.classList.remove("scrolled");
//   }
// });
