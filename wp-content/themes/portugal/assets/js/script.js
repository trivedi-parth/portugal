
// $(document).ready(function(){
//     $('.slider-product').slick({
//         slidesToShow: 3,
//         slidesToScroll: 3,
//         focusOnSelect: true,
//         dots: true,
//         infinite: false,
//         nextArrow: $(".next-doctor"),
//         prevArrow: $(".prev-doctor"),
//         responsive: [
//             {
//                 breakpoint: 1024,
//                 settings: {
//                     slidesToShow: 1,
//                     slidesToScroll: 1,
//                     centerPadding: '0px'
//                 }
//             },
//             {
//                 breakpoint: 768,
//                 settings: {
//                     arrows: false,
//                     dots: false,
//                     centerMode: true,
//                     centerPadding: '0px',
//                     slidesToShow: 1,
//                     slidesToScroll: 1
//                 }
//             },
//             {
//                 breakpoint: 480,
//                 settings: {
//                     arrows: false,
//                     dots: false,
//                     centerMode: true,
//                     centerPadding: '0px',
//                     slidesToShow: 1,
//                     slidesToScroll: 1
//                 }
//             }
//         ]
//     });
// });

$(document).ready(function(){
    $('.slider-product').slick({
      autoplay: true,
      autoplaySpeed: 2000,
      dots: true,
      arrows: true,
      infinite: true,
      speed: 500,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  });