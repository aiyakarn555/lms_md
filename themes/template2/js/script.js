// $(window).load(function(){
//   $("#header").sticky({ 
//     topSpacing: 0
//      });
// });

// Partner
$(document).ready(function(){

   $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});



/* ----------------- Start JS Document ----------------- */

// Page Loader
$(window).load(function () {
    "use strict";    
  $('#loader').fadeOut();
});

$(document).ready(function ($) {
  "use strict"; 
 
     /*---------------------------------------------------*/
    /* Progress Bar
    /*---------------------------------------------------*/    
//    $('.skill-shortcode').appear(function() {
//      $('.progress').each(function(){ 
//        $('.progress-bar').css('width',  function(){ 
//          return ($(this).attr('data-percentage')+'%')});
//      });
//  },{accY: -100});  
  
  
    /*--------------------------------------------------*/
    /* Counter
    /*--------------------------------------------------*/   
//  $('.timer').countTo();
//    $('.counter-item').appear(function() {
//        $('.timer').countTo();
//    },{
//      accY: -100
//    });         
     
  
  /*----------------------------------------------------*/
  /*  Nav Menu & Search
  /*----------------------------------------------------*/
  
  $(".nav > li:has(ul)").addClass("drop");
  $(".nav > li.drop > ul").addClass("dropdown");
  $(".nav > li.drop > ul.dropdown ul").addClass("sup-dropdown");
  
  $('.show-search').click(function() {
    $('.search-form').fadeIn(300);
    $('.search-form input').focus();
  });
  $('.search-form input').blur(function() {
    $('.search-form').fadeOut(300);
  });
        
  /*----------------------------------------------------*/
  /*  Tabs
  /*----------------------------------------------------*/
  
  $('#myTab a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
  
  
  /*----------------------------------------------------*/
  /*  Css3 Transition
  /*----------------------------------------------------*/
  
  $('*').each(function(){
    if($(this).attr('data-animation')) {
      var $animationName = $(this).attr('data-animation'),
        $animationDelay = "delay-"+$(this).attr('data-animation-delay');
      $(this).appear(function() {
        $(this).addClass('animated').addClass($animationName);
        $(this).addClass('animated').addClass($animationDelay);
      });
    }
  });
  
  
  /*----------------------------------------------------*/
  /*  Pie Charts
  /*----------------------------------------------------*/
  
  var pieChartClass = 'pieChart',
        pieChartLoadedClass = 'pie-chart-loaded';
    
  function initPieCharts() {
    var chart = $('.' + pieChartClass);
    chart.each(function() {
      $(this).appear(function() {
        var $this = $(this),
          chartBarColor = ($this.data('bar-color')) ? $this.data('bar-color') : "#F54F36",
          chartBarWidth = ($this.data('bar-width')) ? ($this.data('bar-width')) : 150
        if( !$this.hasClass(pieChartLoadedClass) ) {
          $this.easyPieChart({
            animate: 2000,
            size: chartBarWidth,
            lineWidth: 2,
            scaleColor: false,
            trackColor: "#eee",
            barColor: chartBarColor,
          }).addClass(pieChartLoadedClass);
        }
      });
    });
  }
  initPieCharts();
    
  /*----------------------------------------------------*/
  /*  Animation Progress Bars
  /*----------------------------------------------------*/
  
  $("[data-progress-animation]").each(function() {
    
    var $this = $(this);
    
    $this.appear(function() {
      
      var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
      
      if(delay > 1) $this.css("animation-delay", delay + "ms");
      
      setTimeout(function() { $this.animate({width: $this.attr("data-progress-animation")}, 800);}, delay);

    }, {accX: 0, accY: -50});

  });
  
  /*----------------------------------------------------*/
  /*  Milestone Counter
  /*----------------------------------------------------*/
  
  jQuery('.milestone-block').each(function() {
    jQuery(this).appear(function() {
      var $endNum = parseInt(jQuery(this).find('.milestone-number').text());
      jQuery(this).find('.milestone-number').countTo({
        from: 0,
        to: $endNum,
        speed: 4000,
        refreshInterval: 60,
      });
    },{accX: 0, accY: 0});
  });
  
  /*----------------------------------------------------*/
  /*  Nivo Lightbox
  /*----------------------------------------------------*/
  
//  $('.lightbox').nivoLightbox({
//    effect: 'fadeScale',
//    keyboardNav: true,
//    errorMessage: 'The requested content cannot be loaded. Please try again later.'
//  });
//  
  
  /*----------------------------------------------------*/
  /*  Change Slider Nav Icons
  /*----------------------------------------------------*/
  
  $('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
  $('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
  $('.touch-carousel, .testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
  $('.touch-carousel, .testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');
  $('.read-more').append('<i class="fa fa-angle-right"></i>');
  
  /*----------------------------------------------------*/
  /*  Tooltips & Fit Vids & Parallax & Text Animations
  /*----------------------------------------------------*/
  
  $("body").fitVids();
  
  $('.itl-tooltip').tooltip();
  
  $('.bg-parallax').each(function() {
    $(this).parallax("30%", 0.2);
  });
  
  $('.tlt').textillate({
    loop: true,
    in: {
      effect: 'fadeInUp',
      delayScale: 2,
      delay: 50,
      sync: false,
      shuffle: false,
      reverse: true,
    },
    out: {
      effect: 'fadeOutUp',
      delayScale: 2,
      delay: 50,
      sync: false,
      shuffle: false,
      reverse: true,
    },
  });
 
});

/*----------------------------------------------------*/
/*  Portfolio Isotope
/*----------------------------------------------------*/

jQuery(window).load(function(){
  
  var $container = $('#portfolio');
  $container.isotope({
    layoutMode : 'masonry',
    filter: '*',
    animationOptions: {
      duration: 750,
      easing: 'linear',
      queue: false,
    }
  });

  $('.portfolio-filter ul a').click(function(){
    var selector = $(this).attr('data-filter');
    $container.isotope({
      filter: selector,
      animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false,
      }
    });
    return false;
  });

  var $optionSets = $('.portfolio-filter ul'),
      $optionLinks = $optionSets.find('a');
  $optionLinks.click(function(){
    var $this = $(this);
    if ( $this.hasClass('selected') ) { return false; }
    var $optionSet = $this.parents('.portfolio-filter ul');
    $optionSet.find('.selected').removeClass('selected');
    $this.addClass('selected'); 
  });
  
});
/* ----------------- End JS Document ----------------- */


$(document).ready(function(){
  
  // Styles Switcher
  $(document).ready(function(){
    $('.open-switcher').click(function(){
      if($(this).hasClass('show-switcher')) {
        $('.switcher-box').css({'left': 0});
        $('.open-switcher').removeClass('show-switcher');
        $('.open-switcher').addClass('hide-switcher');
      }else if(jQuery(this).hasClass('hide-switcher')) {
        $('.switcher-box').css({'left': '-212px'});
        $('.open-switcher').removeClass('hide-switcher');
        $('.open-switcher').addClass('show-switcher');
      }
    });
  });
  
  //Top Bar Switcher
  $(".topbar-style").change(function(){
    if( $(this).val() == 1){
      $(".top-bar").removeClass("dark-bar"),
      $(".top-bar").removeClass("color-bar"),
      $(window).resize();
    } else if( $(this).val() == 2){
      $(".top-bar").removeClass("color-bar"),
      $(".top-bar").addClass("dark-bar"),
      $(window).resize();
    } else if( $(this).val() == 3){
      $(".top-bar").removeClass("dark-bar"),
      $(".top-bar").addClass("color-bar"),
      $(window).resize();
    }
  });
  
  //Layout Switcher
  $(".layout-style").change(function(){
    if( $(this).val() == 1){
      $("#container").removeClass("boxed-page"),
      $(window).resize();
    } else{
      $("#container").addClass("boxed-page"),
      $(window).resize();
    }
  });
  
  //Background Switcher
  $('.switcher-box .bg-list li a').click(function() {
    var current = $('.switcher-box select[id=layout-style]').find('option:selected').val();
    if(current == '2') {
      var bg = $(this).css("backgroundImage");
      $("body").css("backgroundImage",bg);
    } else {
      alert('Please select boxed layout');
    }
  });

});

/**
 * Slick Nav 
 */

$('.wpb-mobile-menu').slicknav({
  prependTo: '.navbar-header',
  parentTag: 'margo',
  allowParentLinks: true,
  duplicate: false,
  label: '',
  closedSymbol: '<i class="fa fa-angle-right"></i>',
  openedSymbol: '<i class="fa fa-angle-down"></i>',
});

/**
 * stellar js
 */
//$.stellar({
//   horizontalOffset: 80,
//    verticalOffset: 150
//});


