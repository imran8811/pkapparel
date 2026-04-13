/* ============================================
   SWIPER INITIALIZATIONS
   ============================================ */
// Home slider
if(document.querySelector('.homeSlider')){
  new Swiper('.homeSlider', {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 1,
    autoplay: { delay: 5000 },
    pagination: { el: '.swiper-pagination' },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    scrollbar: { el: '.swiper-scrollbar' }
  });
}

// Product detail thumbs
if(document.querySelector('.productThumbs')){
  var swiper2 = new Swiper(".productThumbs", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
  });
  new Swiper(".productGallery", {
    loop: true,
    spaceBetween: 10,
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    thumbs: { swiper: swiper2 },
  });
}

// Shop carousels — init all [class^=shopCarousel]
document.querySelectorAll('[class*="shopCarousel"]').forEach(function(el){
  new Swiper(el, {
    slidesPerView: 5,
    spaceBetween: 15,
    loop: false,
    navigation: {
      nextEl: el.querySelector('.swiper-button-next'),
      prevEl: el.querySelector('.swiper-button-prev'),
    },
    breakpoints: {
      400:  { slidesPerView: 1 },
      576:  { slidesPerView: 2 },
      768:  { slidesPerView: 3 },
      992:  { slidesPerView: 4 },
      1200: { slidesPerView: 5 },
    }
  });
});

/* ============================================
   CART MANAGEMENT (server-side)
   ============================================ */
if(typeof PIECES_PER_SET === 'undefined') var PIECES_PER_SET = 10;

/* ============================================
   ADD TO CART MODAL (listing pages)
   ============================================ */
(function(){
  document.addEventListener('click', function(e){
    var btn = e.target.closest('.btn-add-cart');
    if(!btn) return;
    e.preventDefault();
    var sizes = btn.dataset.sizes;

    // Populate modal hidden form inputs
    var articleInput = document.getElementById('modalArticle');
    var sizesInput = document.getElementById('modalSizes');
    var priceInput = document.getElementById('modalPrice');
    if(articleInput) articleInput.value = btn.dataset.article || '';
    if(sizesInput) sizesInput.value = sizes || '30,32,34,36,38';
    if(priceInput) priceInput.value = btn.dataset.price || '';

    // Show size badges
    var container = document.getElementById('sizeOptions');
    if(container){
      container.innerHTML = '';
      var sizeArr = (sizes && sizes.trim()) ? sizes.split(',') : ['30','32','34','36','38'];
      sizeArr.forEach(function(s){
        var badge = document.createElement('span');
        badge.className = 'badge bg-secondary';
        badge.textContent = s.trim();
        container.appendChild(badge);
      });
    }

    // Reset qty
    var qtyInput = document.getElementById('modalSetQty');
    if(qtyInput) qtyInput.value = 1;
    var piecesInfo = document.getElementById('modalPiecesInfo');
    if(piecesInfo) piecesInfo.textContent = '1 set = ' + PIECES_PER_SET + ' pieces';

    var modal = new bootstrap.Modal(document.getElementById('sizeSelectModal'));
    modal.show();
  });

  // Modal qty +/- buttons
  document.addEventListener('click', function(e){
    var qtyInput = document.getElementById('modalSetQty');
    var piecesInfo = document.getElementById('modalPiecesInfo');
    if(!qtyInput) return;
    if(e.target.id === 'modalQtyMinus'){
      var v = parseInt(qtyInput.value) || 1;
      qtyInput.value = Math.max(1, v - 1);
    } else if(e.target.id === 'modalQtyPlus'){
      var v2 = parseInt(qtyInput.value) || 1;
      qtyInput.value = v2 + 1;
    } else { return; }
    if(piecesInfo) piecesInfo.textContent = qtyInput.value + ' set(s) = ' + (parseInt(qtyInput.value) * PIECES_PER_SET) + ' pieces';
  });

  document.addEventListener('change', function(e){
    if(e.target.id === 'modalSetQty'){
      var val = Math.max(1, parseInt(e.target.value) || 1);
      e.target.value = val;
      var piecesInfo = document.getElementById('modalPiecesInfo');
      if(piecesInfo) piecesInfo.textContent = val + ' set(s) = ' + (val * PIECES_PER_SET) + ' pieces';
    }
  });
})();

/* ============================================
   PRODUCT DETAIL PAGE
   ============================================ */
(function(){
  // Size chart modal
  var sizeChartBtn = document.getElementById('btnSizeChartModal');
  if(sizeChartBtn){
    sizeChartBtn.addEventListener('click', function(){
      new bootstrap.Modal(document.getElementById('sizeChartModal')).show();
    });
  }

  // Qty buttons (sets) — sync to hidden form field
  var qtyInput = document.getElementById('qty');
  var qtyMinus = document.getElementById('qtyMinus');
  var qtyPlus = document.getElementById('qtyPlus');
  var piecesInfo = document.getElementById('qtyPiecesInfo');
  var hiddenQty = document.getElementById('detailQtyHidden');

  function updatePiecesInfo(){
    if(piecesInfo && qtyInput){
      var sets = parseInt(qtyInput.value) || 1;
      piecesInfo.textContent = sets + ' set(s) = ' + (sets * PIECES_PER_SET) + ' pieces';
    }
    if(hiddenQty && qtyInput){
      hiddenQty.value = qtyInput.value;
    }
  }

  if(qtyInput && qtyMinus && qtyPlus){
    qtyMinus.addEventListener('click', function(){
      var v = parseInt(qtyInput.value) || 1;
      qtyInput.value = Math.max(1, v - 1);
      updatePiecesInfo();
    });
    qtyPlus.addEventListener('click', function(){
      var v = parseInt(qtyInput.value) || 1;
      qtyInput.value = v + 1;
      updatePiecesInfo();
    });
    qtyInput.addEventListener('change', function(){
      qtyInput.value = Math.max(1, parseInt(qtyInput.value) || 1);
      updatePiecesInfo();
    });
  }
})();

var orderNowEl = document.getElementById('orderNowModal');
if(orderNowEl){
  var orderNowModal = new bootstrap.Modal(orderNowEl);
  var btnOrderNow = document.getElementById('btnOrderNow');
  if(btnOrderNow){
    btnOrderNow.addEventListener('click', function(){ orderNowModal.show(); });
  }
}


