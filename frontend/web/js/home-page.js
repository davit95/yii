$(function(){
	$(".next-item").on('click', function(){

		first = $('.easy-to-work .active');
		index = $('.easy-to-work .active').index() - 1;
		if(index < 2){
			$(first).next().addClass('active');
			$(first).removeClass('active');
		}

	});

	$(".previous-item").on('click', function(){

		previous = $('.easy-to-work .active');
		index = $('.easy-to-work .active').index() - 1;
		if(index > 0){
			$(previous).removeClass('active');
			$(previous).prev().addClass('active');
		}

	});

	toggleHomeCarousel();
});
$(window).resize(function() { toggleHomeCarousel(); });

function toggleHomeCarousel(){
  	var width = $(window).width();

    $('#carousel_home_desktop').hide();
    $('#carousel_home_768').hide();
    $('#carousel_home_360').hide();

    if(width > 768){
	     $('#carousel_home_desktop').show();
    }
    else if(width > 360){
        $('#carousel_home_768').show();
    }
    else{
        $('#carousel_home_360').show();
    }

}