const swiper = new Swiper('.homeSlider', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidePerView: 1,
  autoplay: {
    delay: 5000
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  }
});

var swiper2 = new Swiper(".productGallery", {
  slidesPerView: 1,
  freeMode: true,
  watchSlidesProgress: true,
});
var swiper3 = new Swiper(".productThumbs", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});

var orderNowModal = new bootstrap.Modal(document.getElementById('orderNowModal'))

const btnOrderNow = document.getElementById('btnOrderNow');
btnOrderNow.addEventListener("click", (e) => {
  // var modalToggle = document.getElementById('myModal') // relatedTarget
  orderNowModal.show()
  // console.log(e.target);
})


