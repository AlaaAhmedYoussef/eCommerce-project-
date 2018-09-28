$(function () {

	'use strict';

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

	 var passField = $('.password');

	 $('.show-pass').hover(function (){

	 	passField.attr('type', 'text');

	 }, function (){
	 	// when leave (away) hover
	 	passField.attr('type', 'password');

	 });
});


