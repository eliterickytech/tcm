/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 5
Version: 5.3.1
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/
*/
function handleGritterNotificationMessages(title, message) {
	$.gritter.add({
		title: title,
		text: message
	});
	return false;
}

var handlegritternotification = function() {
	$('#add-sticky').click( function() {
		$.gritter.add({
			title: 'this is a sticky notice!',
			text: 'lorem ipsum dolor sit amet, consectetur adipiscing elit. sed tempus lacus ut lectus rutrum placerat. ',
			image: '../assets/img/user/user-2.jpg',
			sticky: true,
			time: '',
			class_name: 'my-sticky-class'
		});
		return false;
	});
	$('#add-regular').click( function() {
		$.gritter.add({
			title: 'this is a regular notice!',
			text: 'this will fade out after a certain amount of time. sed tempus lacus ut lectus rutrum placerat. ',
			image: '../assets/img/user/user-3.jpg',
			sticky: false,
			time: ''
		});
		return false;
	});
	$('#add-max').click( function() {
		$.gritter.add({
			title: 'this is a notice with a max of 3 on screen at one time!',
			text: 'this will fade out after a certain amount of time. sed tempus lacus ut lectus rutrum placerat. ',
			sticky: false,
			image: '../assets/img/user/user-4.jpg',
			before_open: function() {
				if($('.gritter-item-wrapper').length === 3) {
					return false;
				}
			}
		});
		return false;
	});
	$('#add-without-image').click(function(){
		$.gritter.add({
			title: 'this is a notice without an image!',
			text: 'this will fade out after a certain amount of time.'
		});
		return false;
	});
	$('#add-gritter-light').click(function(){
		$.gritter.add({
			title: 'this is a light notification',
			text: 'just add a \'gritter-light\' class_name to your $.gritter.add or globally to $.gritter.options.class_name',
			class_name: 'gritter-light'
		});
		return false;
	});
	$('#add-with-callbacks').click(function(){
		$.gritter.add({
			title: 'this is a notice with callbacks!',
			text: 'the callback is...',
			before_open: function(){
				alert('i am called before it opens');
			},
			after_open: function(e){
				alert('i am called after it opens: \ni am passed the jquery object for the created gritter element...\n' + e);
			},
			before_close: function(manual_close) {
				var manually = (manual_close) ? 'the \'x\' was clicked to close me!' : '';
				alert('i am called before it closes: i am passed the jquery object for the gritter element... \n' + manually);
			},
			after_close: function(manual_close){
				var manually = (manual_close) ? 'the \'x\' was clicked to close me!' : '';
				alert('i am called after it closes. ' + manually);
			}
		});
		return false;
	});
	$('#add-sticky-with-callbacks').click(function(){
		$.gritter.add({
			title: 'this is a sticky notice with callbacks!',
			text: 'sticky sticky notice.. sticky sticky notice...',
			sticky: true,
			before_open: function(){
				alert('i am a sticky called before it opens');
			},
			after_open: function(e){
				alert('i am a sticky called after it opens: \ni am passed the jquery object for the created gritter element...\n' + e);
			},
			before_close: function(e){
				alert('i am a sticky called before it closes: i am passed the jquery object for the gritter element... \n' + e);
			},
			after_close: function(){
				alert('i am a sticky called after it closes');
			}
		});
		return false;
	});
	$('#remove-all').click(function(){
		$.gritter.removeall();
		return false;
	});
	$('#remove-all-with-callbacks').click(function(){
		$.gritter.removeall({
			before_close: function(e){
				alert('i am called before all notifications are closed.  i am passed the jquery object containing all  of gritter notifications.\n' + e);
			},
			after_close: function(){
				alert('i am called after everything has been closed.');
			}
		});
		return false;
	});
};

var handlesweetnotification = function() {
	$('[data-click="swal-primary"]').click(function(e) {
		e.preventdefault();
		swal({
			title: 'are you sure?',
			text: 'you will not be able to recover this imaginary file!',
			icon: 'info',
			buttons: {
				cancel: {
					text: 'cancel',
					value: null,
					visible: true,
					classname: 'btn btn-default',
					closemodal: true,
				},
				confirm: {
					text: 'primary',
					value: true,
					visible: true,
					classname: 'btn btn-primary',
					closemodal: true
				}
			}
		});
	});

	$('[data-click="swal-info"]').click(function(e) {
		e.preventdefault();
		swal({
			title: 'are you sure?',
			text: 'you will not be able to recover this imaginary file!',
			icon: 'info',
			buttons: {
				cancel: {
					text: 'cancel',
					value: null,
					visible: true,
					classname: 'btn btn-default',
					closemodal: true,
				},
				confirm: {
					text: 'info',
					value: true,
					visible: true,
					classname: 'btn btn-info',
					closemodal: true
				}
			}
		});
	});

	$('[data-click="swal-success"]').click(function(e) {
		e.preventdefault();
		swal({
			title: 'are you sure?',
			text: 'you will not be able to recover this imaginary file!',
			icon: 'success',
			buttons: {
				cancel: {
					text: 'cancel',
					value: null,
					visible: true,
					classname: 'btn btn-default',
					closemodal: true,
				},
				confirm: {
					text: 'success',
					value: true,
					visible: true,
					classname: 'btn btn-success',
					closemodal: true
				}
			}
		});
	});

	$('[data-click="swal-warning"]').click(function(e) {
		e.preventdefault();
		swal({
			title: 'are you sure?',
			text: 'you will not be able to recover this imaginary file!',
			icon: 'warning',
			buttons: {
				cancel: {
					text: 'cancel',
					value: null,
					visible: true,
					classname: 'btn btn-default',
					closemodal: true,
				},
				confirm: {
					text: 'warning',
					value: true,
					visible: true,
					classname: 'btn btn-warning',
					closemodal: true
				}
			}
		});
	});

	$('[data-click="swal-danger"]').click(function(e) {
		e.preventdefault();
		swal({
			title: 'are you sure?',
			text: 'you will not be able to recover this imaginary file!',
			icon: 'error',
			buttons: {
				cancel: {
					text: 'cancel',
					value: null,
					visible: true,
					classname: 'btn btn-default',
					closemodal: true,
				},
				confirm: {
					text: 'warning',
					value: true,
					visible: true,
					classname: 'btn btn-danger',
					closemodal: true
				}
			}
		});
	});
};


var notification = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handlegritternotification();
			handlesweetnotification();
		}
	};
}();

$(document).ready(function() {
	notification.init();
});