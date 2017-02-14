$(function(){

	$(document).on('click','.icon_down',function(){
		$('html, body').animate({
		    scrollTop: $(document).height()
		}, 'slow');
	});

	$(document).on('click','.compare_button',function(){
		$('#premium_download_popup').show();
	});

	$('body').click(function() {
		if (!$(this.target).is('.popup')){
		   $(".popup").hide();
		}
	});

	$(document).on('click','.prog',function(){
		last_name = $('.last_name').val();
		first_name = $('.first_name').val();
		target_country = $('.target_country option:selected').text();
		if(last_name!="" && first_name!="" && target_country!= "" && target_country!= "Select Option"){
			NProgress.configure({ showSpinner: false });
			NProgress.start();
		}
	});

	$(document).on('click', '.clickable ', function(evt){
		var self = $(evt.target);
		var link = self.children('a').attr('href');
		window.location = link;
	});

	if ($(window).width() < 980) {

		if($(window).scrollTop() > 50){
			$("header").addClass('fixed');
			$('body header .logo.md-hide img').attr('src', '/images/logo_blue.png');
			$('header .right-menu > ul li.user-menu img').attr('src', '/images/user-menu_blue.png');
		}else{
			$("header").removeClass('fixed');
			$('body header .logo.md-hide img').attr('src', '/images/logo.png');
			$('header .right-menu > ul li.user-menu img').attr('src', '/images/user-menu.png');
		}

		$(document).click(function(){
			$("header .menu").hide();
		});

		$(document).on('scroll', function(){
			$("header .menu").fadeOut();
			if($(window).scrollTop() > 1){
				$("header").addClass('fixed');
				$('body header .logo.md-hide img').attr('src', '/images/logo_blue.png');
				$('header .right-menu > ul li.user-menu img').attr('src', '/images/user-menu_blue.png');
			}else{
				$("header").removeClass('fixed');
				$('body header .logo.md-hide img').attr('src', '/images/logo.png');
				$('header .right-menu > ul li.user-menu img').attr('src', '/images/user-menu.png');
			}
		});

	}

    new Clipboard('.js-copy-to-clipboard');
});
