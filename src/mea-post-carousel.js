jQuery(document).ready(function () {
    //create the control buttons
    const prev = jQuery(document.createElement('button')).prop({
        type: 'button',
        innerHTML: "<box-icon name='chevron-left' color='#7fb736'></box-icon>",
        class: 'prev',
    });
    const next = jQuery(document.createElement('button')).prop({
        type: 'button',
        innerHTML: "<box-icon name='chevron-right' color='#7fb736'></box-icon>",
        class: 'next',
    });
    //attach the carousel
    const carousel = jQuery('.mea-carousel').slick({
        arrows: true,
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        accessibility: true,
        slidesToScroll: 1,
        prevArrow: prev,
        nextArrow: next,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
    //add outer container to style controls
    const slickDots = jQuery(".slick-dots").wrap("<div class='carousel-controls'></div>");
    //add the buttons to the carousel
    jQuery('.carousel-controls').append(prev);
    jQuery('.carousel-controls').append(next);
});