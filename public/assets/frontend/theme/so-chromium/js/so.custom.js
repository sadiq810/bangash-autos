/* Add Custom Code Jquery
 ========================================================*/
$(document).ready(function(){
	// Fix hover on IOS
	$('body').bind('touchstart', function() {}); 
	
	// Messenger posmotion
	/*$( "#close-posmotion-header" ).click(function() {
		$('.promotion-top').toggleClass('hidden-promotion');
		$('body').toggleClass('hidden-promotion-body');

		if($(".promotion-top").hasClass("hidden-promotion")){
			$.cookie("open", 0);
			
		} else{
			$.cookie("open", 1);
		}

	});*/
	
	/*if($.cookie("open") == 0){
		$('.promotion-top').addClass('hidden-promotion');
		$('body').addClass('hidden-promotion-body');
	}*/
	  jQuery(document).ready(function($) {
      var owl_testimonial = $(" .slider-clients-say-h2");
      owl_testimonial.owlCarousel2({
        
        responsive:{
          0:{
            items:1
          },
          480:{
            items:1
          },
          768:{
            items:1
          },
          992:{
            items:1
          },
          1200:{
            items:1
          }
        },

        autoplay:false,
        loop:true,
        nav : true, // Show next and prev buttons
        dots: true,
        navText: ['',''],
        autoplaySpeed : 500,
        navSpeed : 500,
        dotsSpeed : 500,
        autoplayHoverPause: true,
        margin:0,

      });   
    }); 

	 jQuery(document).ready(function($) {
      var owl_cat = $(".cat-wrap.theme2");
      owl_cat.owlCarousel2({
        
        responsive:{
          0:{
            items:1
          },
          480:{
            items:1
          },
          768:{
            items:2
          },
          992:{
            items:3
          },
          1200:{
            items:4
          }
        },

        autoplay:false,
        loop:true,
        nav : true, // Show next and prev buttons
        dots: false,
        navText: ['',''],
        autoplaySpeed : 500,
        navSpeed : 500,
        dotsSpeed : 500,
        autoplayHoverPause: true,
        margin:0,

      });   
    }); 
	  
	jQuery(function(){
		$(window).load(function() {
			var windowswidth = $(window).width();
			var containerwidth = $('.container').width();
			var widthcss = (windowswidth-containerwidth)/2-55;
			var hei = $('.slide13').outerHeight();
			var rtl = jQuery( 'body' ).hasClass( 'rtl' );
			if( !rtl ) {
				jQuery(".custom-scoll").css("left",widthcss);
			}else{
				jQuery(".custom-scoll").css("right",widthcss);
			}
			var navScroll = $("#box-link1");
			
			if (navScroll.length > 0) {
				//$(".custom-scoll").fadeOut();
				jQuery(".custom-scoll").css("top",hei);
				jQuery(".custom-scoll").css("position","absolute");

				$(window).scroll(function() {
					if( $(window).scrollTop() > navScroll.offset().top - 30  ) {
						//$(".custom-scoll").fadeIn();
						
						jQuery(".custom-scoll").css("top",0);
						jQuery(".custom-scoll").css("position","fixed");
					} 
					else {
						//$(".custom-scoll").fadeOut();
						jQuery(".custom-scoll").css("top",navScroll.offset().top);
						jQuery(".custom-scoll").css("position","absolute");
					}
			
				});

	        }
	    })
	});
	
	jQuery(function(){
		$('#nav-scroll').onePageNav({
			currentClass: 'active',
			changeHash: false,
			scrollSpeed: 750,
			scrollThreshold: 0.5,
			filter: '',
			easing: 'swing',
			
		});

		
	});

	// Messenger Top Link
	$('.list-msg').owlCarousel2({
		pagination: false,
		center: false,
		nav: false,
		dots: false,
		loop: true,
		slideBy: 1,
		autoplay: true,
		margin: 30,
		autoplayTimeout: 4500,
		autoplayHoverPause: true,
		autoplaySpeed: 1200,
		startPosition: 0, 
		responsive:{
			0:{
				items:1
			},
			480:{
				items:1
			},
			768:{
				items:1
			},
			1200:{
				items:1
			}
		}
	});






	// Close pop up countdown
	 $( "#so_popup_countdown .customer a" ).click(function() {
	  $('body').toggleClass('hidden-popup-countdown');
	 });
	// =========================================


	// click header search header 
	jQuery(document).ready(function($){
		$( ".search-header-w .icon-search" ).click(function() {
		$('#sosearchpro .search').slideToggle(200);
		$(this).toggleClass('active');
		});
	});

	// add class Box categories
	jQuery(document).ready(function($){

		if($("#accordion-category .panel .panel-collapse").hasClass("in")){
			$('#accordion-category .panel .accordion-toggle').addClass("show");			
		} 
		else{
			$('#accordion-category .panel .accordion-toggle').removeClass("show");
		}

	});


	// custom to show footer center
	$(".button-toggle").click(function () {
		if($(this).children('.showmore').hasClass('active')) $(this).children().removeClass('active');
		else $(this).children().addClass('active');
		
		
		
		if($(this).prev().hasClass('showdown')) $(this).prev().removeClass('showdown').addClass('showup');
		else $(this).prev().removeClass('showup').addClass('showdown');
	}); 


	$(".clearable").each(function() {
  
	  var $inp = $(this).find("input:text"),
	      $cle = $(this).find(".clearable__clear");

	  $inp.on("input", function(){
	    $cle.toggle(!!this.value);
	  });
	  
	  $cle.on("touchstart click", function(e) {
	    e.preventDefault();
	    $inp.val("").trigger("input");
	  });
	  
	});

});
