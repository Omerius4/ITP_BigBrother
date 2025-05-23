
AOS.init({
  // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
  offset: 120, // offset (in px) from the original trigger point
  delay: 0, // values from 0 to 3000, with step 50ms
  duration: 900, // values from 0 to 3000, with step 50ms
  easing: 'ease', // default easing for AOS animations
  once: false, // whether animation should happen only once - while scrolling down
  mirror: false, // whether elements should animate out while scrolling past them
  anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

});

let lastScrollTop = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Scroll down
        navbar.classList.add('hidden-navbar');
    } else {
        // Scroll up
        navbar.classList.remove('hidden-navbar');
    }
    lastScrollTop = scrollTop;
});


document.addEventListener('DOMContentLoaded', function() {
  const scrollToTopButton = document.querySelector('.scroll-to-top');

  window.addEventListener('scroll', function() {
      if (window.scrollY > 300) {
          scrollToTopButton.classList.add('show');
      } else {
          scrollToTopButton.classList.remove('show');
      }
  });

  scrollToTopButton.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
          top: 0,
          behavior: 'smooth'
      });
  });
});