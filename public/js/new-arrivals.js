$('.new-arrivals-banner').owlCarousel({
    loop: true,
    margin: 10,
        responsiveClass:true,

    nav: true,
    dots: false,
    items: 1,
    responsive: {
        0: {
            items: 1,

        },
               300: {
            items: 1,
        },
        600: {
            items: 2,
        },
        1000: {
            items: 2,
        },
        1024: {
            items: 3,
            nav: true,
            loop: false,
        },
        1280:
        {
            items: 4,
            nav: true,
            loop: false,
        },
        1920: {
            items: 5,
            nav: true,
            loop: false
        }
    }
})



// $('.new-arrivals-banner').owlCarousel({
//     loop:true,
//     margin:10,
//     nav:true,
//     arrows:true,
//     responsive:{
//         0:{
//             items:1
//         },
//         600:{
//             items:3
//         },
//         1000:{
//             items:5
//         }
//     }
// })