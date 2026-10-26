AOS.init({
    duration: 680,
    once: true,
    offset: 55
});

/* NAVBAR SCROLL & ACTIVE LINK  */
window.addEventListener('scroll', function() {
    var nav = document.getElementById('nav');
    if (nav) nav.classList.toggle('scrolled', window.scrollY > 60);
    var btt = document.getElementById('btt');
    if (btt) btt.classList.toggle('show', window.scrollY > 300);
    document.querySelectorAll('section[id]').forEach(function(sec) {
        var top = sec.offsetTop - 110,
            bot = top + sec.offsetHeight;
        if (window.scrollY >= top && window.scrollY < bot) {
            document.querySelectorAll('.nav-link').forEach(function(l) {
                l.classList.remove('active');
            });
            var lnk = document.querySelector('.nav-link[href="#' + sec.id + '"]');
            if (lnk) lnk.classList.add('active');
        }
    });
});

/*  SMOOTH SCROLL + MOBILE NAV CLOSE  */
document.querySelectorAll('a[href^="#"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
        var href = this.getAttribute('href');
        if (href === '#') return;
        var t = document.querySelector(href);
        if (t) {
            e.preventDefault();
            // Close Bootstrap mobile navbar if open
            var navCollapse = document.getElementById('navmenu');
            if (navCollapse && navCollapse.classList.contains('show')) {
                var bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                } else {
                    navCollapse.classList.remove('show');
                }
            }
            // Scroll after slight delay to let navbar close
            setTimeout(function() {
                window.scrollTo({
                    top: t.offsetTop - 78,
                    behavior: 'smooth'
                });
            }, 50);
        }
    });
});


var searchOv = document.getElementById('searchOv');
var navSearchBtn = document.getElementById('navSearchBtn');

if (navSearchBtn && searchOv) {
    navSearchBtn.addEventListener('click', function() {
        searchOv.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            var sInp = document.getElementById('searchInput');
            if (sInp) sInp.focus();
        }, 220);
    });
}

var searchClose = document.getElementById('searchClose');
if (searchClose) {
    searchClose.addEventListener('click', closeSearch);
}

// Close when clicking backdrop
if (searchOv) {
    searchOv.addEventListener('click', function(e) {
        if (e.target === searchOv) closeSearch();
    });
}

function closeSearch() {
    if (searchOv) searchOv.classList.remove('open');
    document.body.style.overflow = '';
}

// Category buttons inside search box
document.querySelectorAll('.sovcat').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.sovcat').forEach(function(b) {
            b.classList.remove('active');
        });
        this.classList.add('active');
        var f = this.getAttribute('data-cat');
        closeSearch();
        setTimeout(function() {
            filterMenu(f);
            document.getElementById('menu').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 300);
    });
});

// Real-time Dynamic Menu Search
window.performSearch = function(query) {
    query = (query || '').toLowerCase().trim();
    closeSearch();
    if (!query) return;

    var menuEl = document.getElementById('menu');
    if (!menuEl) {
        window.location.href = '/menu?search=' + encodeURIComponent(query);
        return;
    }

    document.querySelectorAll('.filtbtn').forEach(function(b) {
        b.classList.remove('active');
    });

    document.querySelectorAll('.mwrap').forEach(function(w) {
        var card = w.querySelector('.mcard');
        if (!card) return;
        var title = (card.getAttribute('data-title') || '').toLowerCase();
        var desc = (card.getAttribute('data-desc') || '').toLowerCase();
        var cat = (card.getAttribute('data-cat') || '').toLowerCase();
        var tags = (card.getAttribute('data-tags') || '').toLowerCase();

        if (title.includes(query) || desc.includes(query) || cat.includes(query) || tags.includes(query)) {
            w.classList.remove('gone');
            w.style.opacity = '1';
            w.style.transform = 'translateY(0)';
        } else {
            w.classList.add('gone');
        }
    });

    window.scrollTo({
        top: menuEl.offsetTop - 80,
        behavior: 'smooth'
    });
};

var searchInputEl = document.getElementById('searchInput');
if (searchInputEl) {
    searchInputEl.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            window.performSearch(this.value);
        }
    });
}

var searchBtnEl = document.querySelector('#searchOv .sovinput button');
if (searchBtnEl) {
    searchBtnEl.addEventListener('click', function(e) {
        e.preventDefault();
        window.performSearch(document.getElementById('searchInput').value);
    });
}

// Trending tags click to search
document.querySelectorAll('.sovtrend .ttag').forEach(function(t) {
    t.addEventListener('click', function() {
        var term = this.textContent.trim();
        document.getElementById('searchInput').value = term;
        window.performSearch(term);
    });
});

// Check if search query in URL on page load
window.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var searchParam = urlParams.get('search');
    if (searchParam) {
        setTimeout(function() {
            window.performSearch(searchParam);
        }, 350);
    }
});


$(document).ready(function() {
	$('.magnific_popup').magnificPopup({
	  disableOn: 700,
	  type: 'iframe',
	  mainClass: 'mfp-fade',
	  removalDelay: 160,
	  preloader: false,
	  fixedContentPos: false,
	  disableOn: 300
	});	
});


function filterMenu(cat) {
    // sync filter buttons
    document.querySelectorAll('.filtbtn').forEach(function(b) {
        b.classList.toggle('active', b.getAttribute('data-f') === cat);
    });
    // sync category cards
    document.querySelectorAll('.catcard').forEach(function(c) {
        c.classList.toggle('active', c.getAttribute('data-filter') === cat);
    });
    // show/hide menu cards
    document.querySelectorAll('.mwrap').forEach(function(w) {
        var c = w.getAttribute('data-c');
        if (cat === 'all' || c === cat) {
            w.classList.remove('gone');
            w.style.opacity = '0';
            w.style.transform = 'translateY(16px)';
            setTimeout(function() {
                w.style.transition = 'opacity .38s,transform .38s';
                w.style.opacity = '1';
                w.style.transform = 'translateY(0)';
            }, 60);
        } else {
            w.classList.add('gone');
        }
    });
}

// Filter buttons
document.querySelectorAll('.filtbtn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        filterMenu(this.getAttribute('data-f'));
    });
});

// Category section cards â†’ scroll + filter
document.querySelectorAll('.catcard').forEach(function(card) {
    card.addEventListener('click', function() {
        var f = this.getAttribute('data-filter');
        window.scrollTo({
            top: document.getElementById('menu').offsetTop - 80,
            behavior: 'smooth'
        });
        setTimeout(function() {
            filterMenu(f);
        }, 480);
    });
});


var menuPop = document.getElementById('menuPop');
var mpQty = 1;
var currentOpenedItem = null;

// ==========================================
// PERSISTENT CART SYSTEM
// ==========================================
window.getCart = function() {
    try {
        var saved = localStorage.getItem('fastfood_cart');
        if (!saved) {
            var initial = [
                {
                    title: 'Classic Smash Burger',
                    cat: 'Burgers',
                    img: 'img/menu/1.jpg',
                    price: 14.99,
                    qty: 1
                },
                {
                    title: 'Margherita Royale Pizza',
                    cat: 'Pizza',
                    img: 'img/menu/2.jpg',
                    price: 19.99,
                    qty: 1
                },
                {
                    title: 'Nashville Hot Crispy Chicken',
                    cat: 'Chicken',
                    img: 'img/menu/3.jpg',
                    price: 12.99,
                    qty: 1
                }
            ];
            localStorage.setItem('fastfood_cart', JSON.stringify(initial));
            return initial;
        }
        var cart = JSON.parse(saved);
        return Array.isArray(cart) ? cart : [];
    } catch(e) {
        return [];
    }
};

window.saveCart = function(cart) {
    localStorage.setItem('fastfood_cart', JSON.stringify(cart));
    window.updateCartBadge();
    if (typeof window.renderCartPage === 'function') {
        window.renderCartPage();
    }
};

window.addToCart = function(item, qty) {
    qty = parseInt(qty) || 1;
    var cart = window.getCart();
    var existingIndex = cart.findIndex(function(c) {
        return c.title.toLowerCase().trim() === (item.title || '').toLowerCase().trim();
    });

    if (existingIndex > -1) {
        cart[existingIndex].qty = (cart[existingIndex].qty || 1) + qty;
    } else {
        cart.push({
            title: item.title || 'Special Dish',
            cat: item.cat || 'Dish',
            img: item.img || 'img/menu/1.jpg',
            price: parseFloat(item.price) || 0,
            qty: qty
        });
    }

    window.saveCart(cart);
};

window.updateCartBadge = function() {
    var cart = window.getCart();
    var totalCount = cart.reduce(function(sum, item) {
        return sum + (parseInt(item.qty) || 1);
    }, 0);

    var badges = document.querySelectorAll('#cartCount');
    badges.forEach(function(b) {
        b.textContent = totalCount;
        b.style.transition = 'transform 0.25s ease';
        b.style.transform = 'scale(1.35)';
        setTimeout(function() {
            b.style.transform = 'scale(1)';
        }, 220);
    });
};

function openMenuPop(card) {
    var img = card.getAttribute('data-img');
    var title = card.getAttribute('data-title');
    var cat = card.getAttribute('data-cat');
    var price = card.getAttribute('data-price');
    var old = card.getAttribute('data-old');
    var rating = parseFloat(card.getAttribute('data-rating')) || 5;
    var reviews = card.getAttribute('data-reviews') || '100';
    var cal = card.getAttribute('data-cal') || '500';
    var time = card.getAttribute('data-time') || '15';
    var desc = card.getAttribute('data-desc') || '';
    var tags = card.getAttribute('data-tags') || '';

    var cleanPrice = parseFloat(price.replace(/[^0-9.]/g, '')) || 0;
    currentOpenedItem = {
        title: title,
        cat: cat,
        img: img,
        price: cleanPrice,
        priceFormatted: price
    };

    document.getElementById('mpImg').setAttribute('src', img);
    document.getElementById('mpCat').textContent = cat;
    document.getElementById('mpTitle').textContent = title;

    var full = Math.round(rating),
        empty = 5 - full;
    document.getElementById('mpStars').innerHTML =
        '<i class="fas fa-star"></i>'.repeat(full) + '☆'.repeat(empty) +
        ' <span style="color:#bbb;font-size:.78rem;">' + rating + ' (' + reviews + ' reviews)</span>';

    document.getElementById('mpDesc').textContent = desc;

    document.getElementById('mpPrice').innerHTML =
        price + (old ? '<small style="color:#ccc;text-decoration:line-through;margin-left:8px;font-size:1rem;">' + old + '</small>' : '');

    document.getElementById('mpMeta').innerHTML =
        '<div class="mpm"><div class="mpmv">' + cal + ' kcal</div><div class="mpml">Calories</div></div>' +
        '<div class="mpm"><div class="mpmv">' + time + ' min</div><div class="mpml">Prep Time</div></div>' +
        '<div class="mpm"><div class="mpmv">' + rating + '/5</div><div class="mpml">Rating</div></div>';

    document.getElementById('mpTags').innerHTML =
        tags.split(',').filter(Boolean).map(function(t) {
            return '<span class="mptag">' + t.trim() + '</span>';
        }).join('');

    mpQty = 1;
    document.getElementById('mpQnum').textContent = 1;
    document.getElementById('mpAddCart').innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
    document.getElementById('mpAddCart').style.background = '';

    menuPop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

// Card click open popup
document.querySelectorAll('.mcard').forEach(function(card) {
    card.addEventListener('click', function() {
        openMenuPop(this);
    });
});

// + button  open popup (stop propagation to avoid double firing)
document.querySelectorAll('.madd').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        openMenuPop(this.closest('.mcard'));
    });
});

// Heart toggle (no popup)
document.querySelectorAll('.mhrt').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        var ico = this.querySelector('i');
        ico.classList.toggle('far');
        ico.classList.toggle('fas');
        this.style.color = ico.classList.contains('fas') ? 'var(--primary)' : '#ccc';
    });
});

// Close popup
var mpClose = document.getElementById('mpClose');
if (mpClose) mpClose.addEventListener('click', closeMenuPop);
if (menuPop) {
    menuPop.addEventListener('click', function(e) {
        if (e.target === this) closeMenuPop();
    });
}

function closeMenuPop() {
    if (menuPop) menuPop.classList.remove('open');
    document.body.style.overflow = '';
}

// Qty +/-
var mpPlus = document.getElementById('mpPlus');
if (mpPlus) {
    mpPlus.addEventListener('click', function() {
        var el = document.getElementById('mpQnum');
        if (el) el.textContent = ++mpQty;
    });
}
var mpMinus = document.getElementById('mpMinus');
if (mpMinus) {
    mpMinus.addEventListener('click', function() {
        if (mpQty > 1) {
            var el = document.getElementById('mpQnum');
            if (el) el.textContent = --mpQty;
        }
    });
}

// Add to cart button
var mpAddCart = document.getElementById('mpAddCart');
if (mpAddCart) {
    mpAddCart.addEventListener('click', function() {
        if (currentOpenedItem) {
            window.addToCart(currentOpenedItem, mpQty);
        }
        this.innerHTML = '<i class="fas fa-check"></i> Added to Cart!';
        this.style.background = 'linear-gradient(135deg,var(--green),#1a4a35)';
        var self = this;
        setTimeout(function() {
            closeMenuPop();
            self.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
            self.style.background = '';
        }, 850);
    });
}

// Initialize cart count badge on page load
window.addEventListener('DOMContentLoaded', function() {
    window.updateCartBadge();
});



var resBtn = document.getElementById('resBtn');
if (resBtn) {
    resBtn.addEventListener('click', function() {
        var btn = this;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Booking...';
        btn.disabled = true;
        setTimeout(function() {
            btn.innerHTML = '<i class="fas fa-calendar-check"></i> Confirm Reservation';
            btn.disabled = false;
            var ok = document.getElementById('resOk');
            if (ok) {
                ok.style.display = 'block';
                ok.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }, 1500);
    });
}

var ctcBtn = document.getElementById('ctcBtn');
if (ctcBtn) {
    ctcBtn.addEventListener('click', function() {
        var btn = this;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        btn.disabled = true;
        setTimeout(function() {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
            btn.disabled = false;
            var ok = document.getElementById('ctcOk');
            if (ok) {
                ok.style.display = 'block';
                ok.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }, 1500);
    });
}

var galPop = document.getElementById('galPop');
var galData = [];
var galIdx = 0;

if (galPop) {
    document.querySelectorAll('.gitem').forEach(function(item) {
        galData.push({
            img: item.getAttribute('data-gimg'),
            title: item.getAttribute('data-gtitle'),
            desc: item.getAttribute('data-gdesc')
        });
        item.addEventListener('click', function() {
            openGal(parseInt(this.getAttribute('data-gi')));
        });
    });

    var gpClose = document.getElementById('gpClose');
    if (gpClose) gpClose.addEventListener('click', closeGal);
    galPop.addEventListener('click', function(e) {
        if (e.target === this) closeGal();
    });

    var gpPrev = document.getElementById('gpPrev');
    if (gpPrev) {
        gpPrev.addEventListener('click', function() {
            openGal((galIdx - 1 + galData.length) % galData.length);
        });
    }

    var gpNext = document.getElementById('gpNext');
    if (gpNext) {
        gpNext.addEventListener('click', function() {
            openGal((galIdx + 1) % galData.length);
        });
    }
}

function openGal(i) {
    if (!galPop || !galData[i]) return;
    galIdx = i;
    var g = galData[i];
    var gpImg = document.getElementById('gpImg');
    if (gpImg) gpImg.setAttribute('src', g.img);
    var gpTitle = document.getElementById('gpTitle');
    if (gpTitle) gpTitle.textContent = g.title;
    var gpDesc = document.getElementById('gpDesc');
    if (gpDesc) gpDesc.innerHTML = g.desc;
    galPop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeGal() {
    if (galPop) galPop.classList.remove('open');
    document.body.style.overflow = '';
}

/*  ESC key closes everything */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSearch();
        closeMenuPop();
        closeGal();
        if (typeof $.magnificPopup !== 'undefined') $.magnificPopup.close();
    }
});


if (document.querySelector('.tesSwiper')) {
    new Swiper('.tesSwiper', {
        slidesPerView: 1,
        spaceBetween: 22,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        breakpoints: {
            640: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
}

if (document.getElementById('cdH')) {
    var cH = 8,
        cM = 45,
        cS = 30;
    setInterval(function() {
        cS--;
        if (cS < 0) {
            cS = 59;
            cM--;
        }
        if (cM < 0) {
            cM = 59;
            cH--;
        }
        if (cH < 0) {
            cH = 8;
            cM = 45;
            cS = 30;
        }
        var cdHEl = document.getElementById('cdH');
        var cdMEl = document.getElementById('cdM');
        var cdSEl = document.getElementById('cdS');
        if (cdHEl) cdHEl.textContent = String(cH).padStart(2, '0');
        if (cdMEl) cdMEl.textContent = String(cM).padStart(2, '0');
        if (cdSEl) cdSEl.textContent = String(cS).padStart(2, '0');
    }, 1000);
}

var nlBtn = document.getElementById('nlBtn');
if (nlBtn) {
    nlBtn.addEventListener('click', function() {
        var nlEmailEl = document.getElementById('nlEmail');
        var email = nlEmailEl ? nlEmailEl.value : '';
        if (email && email.includes('@')) {
            var btn = this;
            btn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
            btn.style.background = '#4ade80';
            btn.style.color = '#222';
            if (nlEmailEl) nlEmailEl.value = '';
            setTimeout(function() {
                btn.textContent = 'Subscribe';
                btn.style.background = '';
                btn.style.color = '';
            }, 3000);
        }
    });
}

/*  NUMBER COUNTER ANIMATION*/
var numAnimated = false;
window.addEventListener('scroll', function() {
    var hero = document.getElementById('hero');
    if (!numAnimated && hero && window.scrollY > hero.offsetHeight - 300) {
        numAnimated = true;
        document.querySelectorAll('.snum').forEach(function(el) {
            var txt = el.textContent;
            var num = parseInt(txt);
            var suf = txt.replace(/[0-9]/g, '');
            if (isNaN(num)) return;
            var start = 0;
            var step = Math.ceil(num / 55);
            var iv = setInterval(function() {
                start += step;
                if (start >= num) {
                    start = num;
                    clearInterval(iv);
                }
                el.textContent = start + suf;
            }, 1400 / 55);
        });
    }
});