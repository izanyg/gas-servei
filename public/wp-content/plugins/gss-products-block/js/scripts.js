import { tns } from "../node_modules/tiny-slider/src/tiny-slider.js";

document.querySelectorAll('.gss-slider').forEach(slider => {
    tns({
        container: slider,
        autoWidth: false,
        items: 1, 
        slideBy: 'page',
        autoplay: false,
        nav: false,
        gutter: 20,
        loop: false,
        controls: false,
        mouseDrag: true,
        responsive: {
            340: {
                items: 2,
                gutter: 10,
            },
            640: {
                items: 3,
                gutter: 10,
            },
            768: {
                items: 4.3,
                gutter: 10,
            },
            1024: {
                items: 6.3,
                gutter: 10,
            }
        }
    });
});