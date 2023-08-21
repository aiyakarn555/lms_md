
if ($(window).width() < 1024) {
  // console.log("max 1024");
  // window.onresize = function () {
  //   location.reload(true);
  // };
} else {

  // console.log("min 1024");
  $("#menuleft").addClass("w-push");
  $(".main-content").addClass("ml-push");
  $(".menu-nano .nav>li span").addClass("d-none");

  $(document).ready(function () {
    $(".main-show").hover(function () {
      $("#menuleft").toggleClass("w-push");
      $(".main-content").toggleClass("ml-push");
      $(".menu-nano .nav>li span").toggleClass("d-none");
    });
  });

}

$(".menu-hide").click(function () {
  $(".menu-nano").addClass("main-show");
  $(".menu-hide").css("display","none");
  $(".menu-push").css("display","flex");
  $("#menuleft").removeClass("w-pushshow");
  $(".main-content").removeClass("ml-pushshow");
  $(".menu-nano .nav>li span").removeClass("d-show");
  $("#menuleft").toggleClass("w-push");
  $(".main-content").toggleClass("ml-push");
  $(".menu-nano .nav>li span").toggleClass("d-none");
});

$(".menu-push").click(function () {
  $(".menu-nano").removeClass("main-show");
  $(".menu-push").css("display","none");
  $(".menu-hide").css("display","flex");
  $("#menuleft").removeClass("w-push");
  $(".main-content").removeClass("ml-push");
  $(".menu-nano .nav>li span").removeClass("d-none");
  $("#menuleft").toggleClass("w-pushshow");
  $(".main-content").toggleClass("ml-pushshow");
  $(".menu-nano .nav>li span").toggleClass("d-show");
});



$(window).scroll(function () {
  if ($(window).scrollTop() >= 300) {
    $(".backtotop").css("opacity", "1");
  } else {
    $(".backtotop").css("opacity", "0");
  }
});

$(".backtotop").click(function () {
  $("html, body").animate({
    scrollTop: 0,
  },
    200
  );
});


var swiper = new Swiper(".learning-menu", {
  spaceBetween: 15,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 5000,
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
      spaceBetween: 10,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 10,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 6,
    },
    1440: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
  },
});


$('#myCarousel').slick({
  slidesToShow: 1,
  dots: true,
  speed: 300,
  autoplay: true,
  fade: true,
  cssEase: 'linear'
});

$(".coursequestion-num").owlCarousel({
  margin: 0,
  loop: false,
  center: false,
  nav: true,
  dots: false,
  autoHeight: true,
  stagePadding: 40,
  responsive: {
    0: {
      items: 3,
      slideBy: 3,
    },
    500: {
      items: 5,
      slideBy: 5,
    },
    768: {
      items: 10,
      slideBy: 10,
    }
  }
});


$("#menu-index").owlCarousel({
  items: 5,
  animateOut: "fadeOut",
  loop: false,
  margin: 0,
  responsiveClass: true,
  responsive: {
    0: {
      items: 2,
    },
    600: {
      items: 2,
    },
    1000: {
      items: 5,
    },
  },
});



$(".course-main").owlCarousel({
  items: 4,
  animateOut: "fadeOut",
  loop: false,
  margin: 20,
  // nav: true,
  // navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
    },
    600: {
      items: 3,
    },
    1000: {
      items: 4,
    },
  },
});

$(".library-main").owlCarousel({
  items: 4,
  animateOut: "fadeOut",
  loop: false,
  margin: 20,
  nav: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
    },
    600: {
      items: 3,
    },
    1000: {
      items: 4,
    },
  },
});