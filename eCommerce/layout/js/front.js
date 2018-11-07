$(function () {

	'use strict';

	//Switch between login & signup

	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		//get the data-class when click on it ..now it can be like
		// .signup  or .login

		$('.' + $(this).data('class')).fadeIn(100);

	});
	
	// Trigger the SelectBoxIt

	  $("select").selectBoxIt({

	  	autoWidth: false
	  	
	  });

	// Hide PlaceHolder On Form Focus

	$('[placeholder]').focus(function (){

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	 }).blur(function () {

	 	$(this).attr('placeholder', $(this).attr('data-text'));

	 });

	 //Add Asterisk on required field

	 $('input').each(function (){

	 	if ($(this).attr('required') === 'required'){

	 		$(this).after('<span class="asterisk">*</span>');
	 		
	 	}
	 });


	 // Convert password field to text field on hover

	 // var passField = $('.password');

	 // $('.show-pass').hover(function (){

	 // 	passField.attr('type', 'text');

	 // }, function (){
	 // 	// when leave (away) hover
	 // 	passField.attr('type', 'password');

	 // });


	 // confirmation message to insure that you wanna delete the member

	 $('.confirm').click(function (){

	 	return confirm('Are you sure?');
	 	
	 });

	//live change for ads here using data-class
	$('.live').keyup(function () {

		$($(this).data('class')).text($(this).val());

	});

	// live for name
	// $('.live-name').keyup(function () {

	// 	$('.live-preview .caption h3').text($(this).val());

	//  });
	

	// $('.live-desc').keyup(function () {

	// 	$('.live-preview .caption p').text($(this).val());

	//  });

	// $('.live-price').keyup(function () {

	// 	$('.live-preview .price-tag').text('$' + $(this).val());

	//  });
});


