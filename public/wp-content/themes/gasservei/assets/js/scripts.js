import '../sass/styles.scss';

//Hide or reveal sticky add-to-cart-bar
const stickybar = document.getElementById('sticky-add-to-cart');
const scrollUp = "scroll-up";
const scrollDown = "scroll-down";
let lastScroll = 0;

window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (!stickybar) {
        return;
    }

    if (currentScroll > 700) {
        // down
        stickybar.classList.remove(scrollUp);
        stickybar.classList.add(scrollDown);
    } else {
        // up
        stickybar.classList.remove(scrollDown);
        stickybar.classList.add(scrollUp);
    }

    lastScroll = currentScroll;
});
window.addEventListener('load', function(){
    let searcher = document.querySelector(".home .wc-block-product-search__fields");
    let menuSearcher = document.querySelector('#menu-search-block');
    if(searcher){
        searcher.addEventListener("click", function(e) {
            console.log('header')
            e.stopPropagation();
            e.preventDefault();
            document.querySelector('li.search-button a').click();
            document.getElementById('search-input').focus();
        });
    }
    if(menuSearcher){
        menuSearcher.addEventListener("click", function(e) {
            console.log('menu')
            e.stopPropagation();
            e.preventDefault();
            document.querySelector('li.search-button a').click();
            document.getElementById('search-input').focus();
        });
    }
});


// Shop sidebar menu accordion
window.addEventListener('load', function(){
    document.querySelectorAll("#gss_sidebar_categories .arrow").forEach(item => {
        item.addEventListener('click', event => {
          item.closest('li').classList.toggle('active');
        })
      })
});





// focus on search
jQuery(function($) {
    const searchButton = $("li.search-button");
    const searchInput = $("#search-input");
    searchButton.on("click", (e) => {
        setTimeout(() => {
            searchInput.focus();
            console.log(searchInput);
        }, 400);
    })
});


window.addEventListener('load', function(){
    let sliderHome = document.getElementById('slider-home');
    if(sliderHome){
        createHomeSlider(sliderHome);
        var sliderHomeTimer = setInterval(changeHomeSlide, 5000);
    }

    document.addEventListener('click',function(e){
        if(e.target && e.target.classList.contains('dot')){
            let sliderElements = document.getElementById('slider-home-wrap').children;
            for (let element of sliderElements) {
                element.classList.remove('active');
            }

            let dots = document.querySelectorAll('#slider-home .dot');
            for (let dot of dots) {
                dot.classList.remove('active');
            }
            e.target.classList.add('active');
            sliderElements[e.target.dataset.slide].classList.add('active');
            clearInterval(sliderHomeTimer);
            sliderHomeTimer = setInterval(changeHomeSlide, 5000);
         }
     });
     
});
function createHomeSlider(sliderHome){

    sliderHome.innerHTML =
        '<div id="slider-home-wrap">'+
        sliderHome.innerHTML
        +'</div>';

    let sliderElements = document.getElementById('slider-home-wrap');
    let elements = sliderElements.children;
    elements[0].classList.add('active');


    let dots = document.createElement("div")
    dots.classList.add('dots');
    for( let i = 0; i < elements.length; i++ ){
        let dot = document.createElement("div")
        dot.classList.add('dot');
        dot.dataset.slide = i;
        if(i == 0){
            dot.classList.add('active');
        }
        dots.appendChild(dot);
    }
    sliderHome.appendChild(dots);

    //Show slider
    sliderHome.classList.add('ready');

}
function changeHomeSlide(){
    let activeDot = document.querySelector('#slider-home .dot.active');
    let nextDot;
    if(activeDot.nextSibling ===  null){
        nextDot = document.querySelector('#slider-home .dot');
    }else{
        nextDot = activeDot.nextSibling;
    }
    nextDot.click();
}

jQuery(function($) {
    $("body.single-product td.quantity form.variable-cart").on("change", "input.qty, input.custom-qty", function() {
        $(this).closest('tr').find('button').attr("data-quantity", this.value);
    });


    //  Simple Product - Build and display notification on ajax add to cart
    $('body.gbt_custom_notif.single-product').on('click touchend', '.variations .ajax_add_to_cart', function(e) {

        // get product's image
        if ($('body').find('.product_layout_classic').length > 0) {
            var imgSrc = $('.woocommerce-product-gallery .woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image img').attr('src') || "";
        } else {
            var imgSrc = $('.woocommerce-product-gallery__wrapper .product_images .product-image:first-child img').attr('src') || "";
        }

        // get product's title
        var prodTitle = $('.product_title').html() || "";

        gbt_cn_onAddedToCart($(this), 'added', function() {
            $('#content').prepend('<div class="woocommerce-message"><div class="product_notification_wrapper"><div class="product_notification_background"><img src="' + imgSrc + '" alt="Notification Image" /></div><div class="product_notification_text"><div>' + gbt_cn_info.cartButton + '&quot;' + prodTitle + '&quot; ' + gbt_cn_info.addedToCartMessage + '</div></div></div></div>');
            // $('.button.added').removeClass('added');
        });
    });

});


function gbt_cn_onAddedToCart(selector, theclass, callback) {
    if ("MutationObserver" in window) {
        var onMutationsObserved = function(mutations) {
            mutations.forEach(function(mutation) {
                if (theclass != "") {
                    if ((!mutation.oldValue || !mutation.oldValue.match(theclass) && mutation.oldValue.match('loading')) &&
                        mutation.target.classList && mutation.target.classList.contains(theclass)) {
                        callback();
                    }
                } else {
                    if (!mutation.oldValue || mutation.oldValue.match('loading')) {
                        callback();
                    }
                }
            });
        };

        var target = selector[0];
        var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
        var observer = new MutationObserver(onMutationsObserved);
        var config = { attributes: true, attributeOldValue: true, attributeFilter: ['class'] };
        observer.observe(target, config);
    }
}

//Tabs
jQuery(function($) {
    $('#distributors-tabs .dt-button').click(function() {
        let type = $(this).attr('data-type');
        console.log(type);
        let content = $('.dt-content[data-type="' + type + '"]');
        $('.dt-content').removeClass('active');
        $('.dt-button').removeClass('active');

        $(this).addClass('active');
        content.addClass('active');
        console.log(content);
    });
});

//Accordion
jQuery(function($) {
    $('.accordion h3').click(function() {
        $(this).parent().toggleClass('active');
    });
});


//Disable current language click
jQuery(function($) {    
    jQuery('.wpml-ls-current-language > a').click(function(e){ e.preventDefault(); });
});
//open submenu when click on parent in mobile
jQuery(function($) {    
    jQuery('.mobile-navigation.primary-navigation .menu-item-has-children > a').click(function(e){ 
        e.preventDefault(); 
        let parent = $(this).parent();
        parent.find('.sub-menu').toggleClass('open');
    });
});