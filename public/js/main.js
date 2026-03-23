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
      576:  { slidesPerView: 2 },
      768:  { slidesPerView: 3 },
      992:  { slidesPerView: 4 },
      1200: { slidesPerView: 5 },
    }
  });
});

/* ============================================
   CART MANAGEMENT (localStorage)
   ============================================ */
var PIECES_PER_SET = 10;

var PkCart = {
  KEY: 'pk_cart',
  ORDERS_KEY: 'pk_orders',

  getItems: function(){
    try { return JSON.parse(localStorage.getItem(this.KEY)) || []; }
    catch(e){ return []; }
  },

  save: function(items){
    localStorage.setItem(this.KEY, JSON.stringify(items));
    this.updateBadge();
  },

  addItem: function(product){
    var items = this.getItems();
    var key = product.article;
    var found = false;
    for(var i = 0; i < items.length; i++){
      if(items[i].article === key){
        items[i].sets += (product.sets || 1);
        found = true;
        break;
      }
    }
    if(!found){
      items.push({
        article: product.article,
        name: product.name,
        price: parseFloat(product.price) || 0,
        dept: product.dept,
        category: product.category,
        slug: product.slug,
        sizes: product.sizes || '30,32,34,36,38',
        sets: product.sets || 1
      });
    }
    this.save(items);
    this.showToast(product.name + ' — ' + (product.sets || 1) + ' set(s) added to cart!');
  },

  removeItem: function(index){
    var items = this.getItems();
    items.splice(index, 1);
    this.save(items);
  },

  updateSets: function(index, sets){
    var items = this.getItems();
    if(items[index]){
      items[index].sets = Math.max(1, parseInt(sets) || 1);
      this.save(items);
    }
  },

  clear: function(){
    localStorage.removeItem(this.KEY);
    this.updateBadge();
  },

  getTotal: function(){
    return this.getItems().reduce(function(sum, item){
      return sum + (item.price * item.sets * PIECES_PER_SET);
    }, 0);
  },

  getTotalPieces: function(){
    return this.getItems().reduce(function(sum, item){
      return sum + (item.sets * PIECES_PER_SET);
    }, 0);
  },

  getTotalSets: function(){
    return this.getItems().reduce(function(sum, item){
      return sum + item.sets;
    }, 0);
  },

  updateBadge: function(){
    var badge = document.getElementById('cartBadge');
    if(badge){
      var count = this.getTotalSets();
      badge.textContent = count;
      badge.style.display = count > 0 ? 'block' : 'none';
    }
  },

  showToast: function(msg){
    var container = document.querySelector('.toast-container');
    if(!container){
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }
    var toast = document.createElement('div');
    toast.className = 'alert alert-success alert-dismissible fade show';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = '<i class="fas fa-check-circle me-1"></i> ' + msg +
      '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    container.appendChild(toast);
    setTimeout(function(){ if(toast.parentNode) toast.remove(); }, 3000);
  },

  // Orders
  getOrders: function(){
    try { return JSON.parse(localStorage.getItem(this.ORDERS_KEY)) || []; }
    catch(e){ return []; }
  },

  saveOrder: function(order){
    var orders = this.getOrders();
    orders.unshift(order);
    localStorage.setItem(this.ORDERS_KEY, JSON.stringify(orders));
  }
};

// Update badge on every page load
document.addEventListener('DOMContentLoaded', function(){ PkCart.updateBadge(); });

/* ============================================
   ADD TO CART BUTTONS (listing pages)
   ============================================ */
(function(){
  var pendingProduct = null;

  document.addEventListener('click', function(e){
    var btn = e.target.closest('.btn-add-cart');
    if(!btn) return;
    e.preventDefault();
    var sizes = btn.dataset.sizes;
    var product = {
      article: btn.dataset.article,
      name: btn.dataset.name,
      price: btn.dataset.price,
      dept: btn.dataset.dept,
      category: btn.dataset.category,
      slug: btn.dataset.slug,
      sizes: sizes || '30,32,34,36,38',
      sets: 1
    };

    // Show bundle modal
    pendingProduct = product;
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
      var qtyInput = document.getElementById('modalSetQty');
      if(qtyInput) qtyInput.value = 1;
      var piecesInfo = document.getElementById('modalPiecesInfo');
      if(piecesInfo) piecesInfo.textContent = '1 set = ' + PIECES_PER_SET + ' pieces';
      var modal = new bootstrap.Modal(document.getElementById('sizeSelectModal'));
      modal.show();
    }
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

  // Confirm add from modal
  var confirmBtn = document.getElementById('confirmAddCart');
  if(confirmBtn){
    confirmBtn.addEventListener('click', function(){
      if(pendingProduct){
        var qtyInput = document.getElementById('modalSetQty');
        pendingProduct.sets = parseInt(qtyInput ? qtyInput.value : 1) || 1;
        PkCart.addItem(pendingProduct);
        pendingProduct = null;
      }
      bootstrap.Modal.getInstance(document.getElementById('sizeSelectModal')).hide();
    });
  }
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

  // Qty buttons (sets)
  var qtyInput = document.getElementById('qty');
  var qtyMinus = document.getElementById('qtyMinus');
  var qtyPlus = document.getElementById('qtyPlus');
  var piecesInfo = document.getElementById('qtyPiecesInfo');

  function updatePiecesInfo(){
    if(piecesInfo && qtyInput){
      var sets = parseInt(qtyInput.value) || 1;
      piecesInfo.textContent = sets + ' set(s) = ' + (sets * PIECES_PER_SET) + ' pieces';
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

  // Add to cart from detail page
  var detailBtn = document.getElementById('detailAddCart');
  if(detailBtn){
    detailBtn.addEventListener('click', function(){
      var product = {
        article: detailBtn.dataset.article,
        name: detailBtn.dataset.name,
        price: detailBtn.dataset.price,
        dept: detailBtn.dataset.dept,
        category: detailBtn.dataset.category,
        slug: detailBtn.dataset.slug,
        sizes: detailBtn.dataset.sizes || '30,32,34,36,38',
        sets: parseInt(qtyInput ? qtyInput.value : 1) || 1
      };
      PkCart.addItem(product);
    });
  }

  // Buy Now
  var buyNowBtn = document.getElementById('buyNowBtn');
  if(buyNowBtn){
    buyNowBtn.addEventListener('click', function(){
      var product = {
        article: detailBtn.dataset.article,
        name: detailBtn.dataset.name,
        price: detailBtn.dataset.price,
        dept: detailBtn.dataset.dept,
        category: detailBtn.dataset.category,
        slug: detailBtn.dataset.slug,
        sizes: detailBtn.dataset.sizes || '30,32,34,36,38',
        sets: parseInt(qtyInput ? qtyInput.value : 1) || 1
      };
      PkCart.addItem(product);
      // Link will navigate to /checkout
    });
  }
})();

/* ============================================
   CART PAGE
   ============================================ */
(function(){
  var tbody = document.getElementById('cartTableBody');
  if(!tbody) return;

  function renderCart(){
    var items = PkCart.getItems();
    var cartEmpty = document.getElementById('cartEmpty');
    var cartContent = document.getElementById('cartContent');

    if(items.length === 0){
      cartEmpty.classList.remove('d-none');
      cartContent.classList.add('d-none');
      return;
    }
    cartEmpty.classList.add('d-none');
    cartContent.classList.remove('d-none');

    var html = '';
    var total = 0;
    var totalSets = 0;
    items.forEach(function(item, i){
      var pieces = item.sets * PIECES_PER_SET;
      var subtotal = item.price * pieces;
      total += subtotal;
      totalSets += item.sets;
      html += '<tr>' +
        '<td><img src="/uploads/' + item.article + '/front.jpg" alt="' + item.name + '" /></td>' +
        '<td><a href="/wholesale-shop/' + item.dept + '/' + item.category + '/' + item.slug + '-' + item.article + '" class="text-capitalize">' + item.name + '</a></td>' +
        '<td><small>' + (item.sizes || '30,32,34,36,38').split(',').join(', ') + '</small></td>' +
        '<td>PKR ' + item.price.toLocaleString() + '</td>' +
        '<td><div class="d-flex align-items-center gap-1">' +
        '<button class="btn btn-sm btn-outline-secondary cart-set-minus" data-i="' + i + '">-</button>' +
        '<input type="number" class="form-control form-control-sm cart-set-input" value="' + item.sets + '" min="1" data-i="' + i + '" />' +
        '<button class="btn btn-sm btn-outline-secondary cart-set-plus" data-i="' + i + '">+</button>' +
        '</div></td>' +
        '<td>' + pieces + '</td>' +
        '<td class="fw-bold">PKR ' + subtotal.toLocaleString() + '</td>' +
        '<td><button class="btn btn-sm btn-outline-danger cart-remove" data-i="' + i + '"><i class="fas fa-times"></i></button></td>' +
        '</tr>';
    });
    tbody.innerHTML = html;
    document.getElementById('summaryCount').textContent = totalSets;
    document.getElementById('summarySubtotal').textContent = 'PKR ' + total.toLocaleString();
    document.getElementById('summaryTotal').textContent = 'PKR ' + total.toLocaleString();
  }

  renderCart();

  tbody.addEventListener('click', function(e){
    var btn = e.target.closest('[data-i]');
    if(!btn) return;
    var i = parseInt(btn.dataset.i);
    if(btn.classList.contains('cart-remove')){
      PkCart.removeItem(i);
      renderCart();
    } else if(btn.classList.contains('cart-set-minus')){
      var items = PkCart.getItems();
      if(items[i] && items[i].sets > 1){
        PkCart.updateSets(i, items[i].sets - 1);
        renderCart();
      }
    } else if(btn.classList.contains('cart-set-plus')){
      var items2 = PkCart.getItems();
      if(items2[i]){
        PkCart.updateSets(i, items2[i].sets + 1);
        renderCart();
      }
    }
  });

  tbody.addEventListener('change', function(e){
    if(e.target.classList.contains('cart-set-input')){
      var i = parseInt(e.target.dataset.i);
      PkCart.updateSets(i, e.target.value);
      renderCart();
    }
  });

  var clearBtn = document.getElementById('clearCartBtn');
  if(clearBtn){
    clearBtn.addEventListener('click', function(){
      if(confirm('Clear all items from cart?')){
        PkCart.clear();
        renderCart();
      }
    });
  }
})();

/* ============================================
   CHECKOUT PAGE
   ============================================ */
(function(){
  var checkoutItems = document.getElementById('checkoutItems');
  if(!checkoutItems) return;

  var items = PkCart.getItems();
  var checkoutEmpty = document.getElementById('checkoutEmpty');
  var checkoutContent = document.getElementById('checkoutContent');

  if(items.length === 0){
    checkoutEmpty.classList.remove('d-none');
    checkoutContent.classList.add('d-none');
    return;
  }
  checkoutEmpty.classList.add('d-none');
  checkoutContent.classList.remove('d-none');

  var total = 0;
  var html = '';
  items.forEach(function(item){
    var pieces = item.sets * PIECES_PER_SET;
    var sub = item.price * pieces;
    total += sub;
    html += '<div class="checkout-item">' +
      '<img src="/uploads/' + item.article + '/front.jpg" alt="' + item.name + '" />' +
      '<div class="checkout-item-info">' +
      '<strong class="text-capitalize">' + item.name + '</strong>' +
      '<small>Sizes: ' + (item.sizes || '30,32,34,36,38').split(',').join(', ') + ' | ' + item.sets + ' set(s) = ' + pieces + ' pcs</small>' +
      '</div>' +
      '<span class="fw-bold">PKR ' + sub.toLocaleString() + '</span>' +
      '</div>';
  });
  checkoutItems.innerHTML = html;
  document.getElementById('chkSubtotal').textContent = 'PKR ' + total.toLocaleString();
  document.getElementById('chkTotal').textContent = 'PKR ' + total.toLocaleString();

  // Place order
  document.getElementById('placeOrderBtn').addEventListener('click', function(){
    var form = document.getElementById('checkoutForm');
    if(!form.checkValidity()){
      form.classList.add('was-validated');
      return;
    }

    var order = {
      id: 'PK-' + Date.now(),
      date: new Date().toISOString().split('T')[0],
      items: PkCart.getItems(),
      total: total,
      totalPieces: PkCart.getTotalPieces(),
      status: 'pending',
      shipping: {
        name: document.getElementById('shFullName').value,
        email: document.getElementById('shEmail').value,
        phone: document.getElementById('shCountryCode').value + document.getElementById('shPhone').value,
        address: document.getElementById('shAddress').value,
        city: document.getElementById('shCity').value,
        state: document.getElementById('shState').value,
        country: document.getElementById('shCountry').value,
        notes: document.getElementById('shNotes').value
      }
    };

    PkCart.saveOrder(order);
    localStorage.setItem('pk_last_order_id', order.id);
    PkCart.clear();
    window.location.href = '/order-placed';
  });
})();

/* ============================================
   ORDERS PAGE
   ============================================ */
(function(){
  var ordersBody = document.getElementById('ordersTableBody');
  if(!ordersBody) return;

  var orders = PkCart.getOrders();
  var ordersEmpty = document.getElementById('ordersEmpty');
  var ordersContent = document.getElementById('ordersContent');

  if(orders.length === 0){
    ordersEmpty.classList.remove('d-none');
    ordersContent.classList.add('d-none');
    return;
  }
  ordersEmpty.classList.add('d-none');
  ordersContent.classList.remove('d-none');

  var html = '';
  orders.forEach(function(order, idx){
    var totalPieces = order.items.reduce(function(s, it){ return s + (it.sets * PIECES_PER_SET); }, 0);
    var totalSets = order.items.reduce(function(s, it){ return s + it.sets; }, 0);
    html += '<tr>' +
      '<td><strong>' + order.id + '</strong></td>' +
      '<td>' + order.date + '</td>' +
      '<td>' + totalSets + ' set(s) / ' + totalPieces + ' pcs</td>' +
      '<td class="fw-bold">PKR ' + order.total.toLocaleString() + '</td>' +
      '<td><span class="order-status ' + order.status + '">' + order.status.charAt(0).toUpperCase() + order.status.slice(1) + '</span></td>' +
      '<td><button class="btn btn-sm btn-outline-primary order-detail-btn" data-idx="' + idx + '">Details</button></td>' +
      '</tr>';
  });
  ordersBody.innerHTML = html;

  ordersBody.addEventListener('click', function(e){
    var btn = e.target.closest('.order-detail-btn');
    if(!btn) return;
    var idx = parseInt(btn.dataset.idx);
    var order = orders[idx];
    if(!order) return;

    var body = document.getElementById('orderDetailBody');
    var dhtml = '<p><strong>Order ID:</strong> ' + order.id + '</p>' +
      '<p><strong>Date:</strong> ' + order.date + '</p>' +
      '<p><strong>Status:</strong> <span class="order-status ' + order.status + '">' + order.status.charAt(0).toUpperCase() + order.status.slice(1) + '</span></p>' +
      '<hr /><h6>Shipping</h6>' +
      '<p>' + order.shipping.name + '<br/>' + order.shipping.address + '<br/>' +
      order.shipping.city + (order.shipping.state ? ', ' + order.shipping.state : '') + ', ' + order.shipping.country + '<br/>' +
      order.shipping.phone + '<br/>' + order.shipping.email + '</p>';
    if(order.shipping.notes){
      dhtml += '<p><strong>Notes:</strong> ' + order.shipping.notes + '</p>';
    }
    dhtml += '<hr /><h6>Items</h6><table class="table table-sm"><thead><tr><th>Product</th><th>Sizes</th><th>Sets</th><th>Pieces</th><th>Price</th></tr></thead><tbody>';
    order.items.forEach(function(it){
      var pcs = it.sets * PIECES_PER_SET;
      dhtml += '<tr><td class="text-capitalize">' + it.name + '</td><td>' + (it.sizes || '30,32,34,36,38').split(',').join(', ') + '</td><td>' + it.sets + '</td><td>' + pcs + '</td><td>PKR ' + (it.price * pcs).toLocaleString() + '</td></tr>';
    });
    dhtml += '</tbody></table>';
    dhtml += '<div class="text-end fw-bold fs-5">Total: PKR ' + order.total.toLocaleString() + '</div>';
    body.innerHTML = dhtml;
    new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
  });
})();

var orderNowEl = document.getElementById('orderNowModal');
if(orderNowEl){
  var orderNowModal = new bootstrap.Modal(orderNowEl);
  var btnOrderNow = document.getElementById('btnOrderNow');
  if(btnOrderNow){
    btnOrderNow.addEventListener('click', function(){ orderNowModal.show(); });
  }
}


