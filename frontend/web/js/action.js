$(function(){
		$(".link").click(function(){
			$(".links").val(" ");
		});
		var url = $('#multiple_form').attr('data-url');
		$("#paypal_pm").click(function(){
			$('#multiple_form').attr('action',url+'/paypal');
		})
		$(".payssion").click(function(){
			$('#multiple_form').attr('action',url+'/payssion');
		})

		$(".mobile-menu").on("click", function(){
			$("header .menu").toggle();
			return false;
		});
});