document.addEventListener("DOMContentLoaded", function() {

	// Custom JS
	if (window.matchMedia("(max-width: 768px)").matches) {


		$('body').on('click', '.basic', function() {
			$('.basic').addClass('active');
			$('.individual, .pro, .enterprice').removeClass('active');
			$('.b').show();
			$('.i, .p, .e').hide();
		});

		$('body').on('click', '.individual', function() {
			$('.individual').addClass('active');
			$('.basic, .pro, .enterprice').removeClass('active');
			$('.i').show();
			$('.b, .p, .e').hide();
		});

		$('body').on('click', '.pro', function() {
			$('.pro').addClass('active');
			$('.basic, .individual, .enterprice').removeClass('active');
			$('.p').show();
			$('.b, .i, .e').hide();
		});

		$('body').on('click', '.enterprice', function() {
			$('.enterprice').addClass('active');
			$('.basic, .individual, .pro').removeClass('active');
			$('.e').show();
			$('.b, .i, .p').hide();
		});
	}


	// Menu toggle
	$(".toggle-mnu").click(function() {
		$(this).toggleClass("on");
		$('body, html').toggleClass("ovf")
		$("#menu").fadeToggle();
		return false;
	});



// Disallow scroll for mobile menu
(function () {
	var _overlay = document.getElementById('menu');
    var _clientY = null; // remember Y position on touch start

    _overlay.addEventListener('touchstart', function (event) {
    	if (event.targetTouches.length === 1) {
            // detect single touch
            _clientY = event.targetTouches[0].clientY;
        }
    }, false);

    _overlay.addEventListener('touchmove', function (event) {
    	if (event.targetTouches.length === 1) {
            // detect single touch
            disableRubberBand(event);
        }
    }, false);

    function disableRubberBand(event) {
    	var clientY = event.targetTouches[0].clientY - _clientY;

    	if (_overlay.scrollTop === 0 && clientY > 0) {
            // element is at the top of its scroll
            event.preventDefault();
        }

        if (isOverlayTotallyScrolled() && clientY < 0) {
            //element is at the top of its scroll
            event.preventDefault();
        }
    }

    function isOverlayTotallyScrolled() {
        // https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollHeight#Problems_and_solutions
        return _overlay.scrollHeight - _overlay.scrollTop <= _overlay.clientHeight;
    }
}())









jQuery(document).ready(function ($) {

	if (window.matchMedia("(max-width: 767px)").matches) {
				// var res = $('.block-2').outerHeight(true);
				// console.log(res)
				$('.js-sidebar-menu').scrollToFixed({
					marginTop: $('header').outerHeight(true),
              //limit: res,
              limit: $($('.stopper')[0]).offset().top - 200,
              zIndex: 9
          });

			}
		});



(function() {
	var _overlay = document.getElementById('menu');
    var _clientY = null; // remember Y position on touch start

    _overlay.addEventListener('touchstart', function(event) {
    	if (event.targetTouches.length === 1) {
            // detect single touch
            _clientY = event.targetTouches[0].clientY;
        }
    }, false);

    _overlay.addEventListener('touchmove', function(event) {
    	if (event.targetTouches.length === 1) {
            // detect single touch
            disableRubberBand(event);
        }
    }, false);

    function disableRubberBand(event) {
    	var clientY = event.targetTouches[0].clientY - _clientY;

    	if (_overlay.scrollTop === 0 && clientY > 0) {
            // element is at the top of its scroll
            event.preventDefault();
        }

        if (isOverlayTotallyScrolled() && clientY < 0) {
            //element is at the top of its scroll
            event.preventDefault();
        }
    }

    function isOverlayTotallyScrolled() {
        // https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollHeight#Problems_and_solutions
        return _overlay.scrollHeight - _overlay.scrollTop <= _overlay.clientHeight;
    }
}())



// Sticky header
$(document).scroll(function(e){
	var scrollTop = $(document).scrollTop();
	if(scrollTop > 255){
			//console.log(scrollTop);
			$('header').addClass('sticky');
		} else {
			$('header').removeClass('sticky');
		}
	});


// Init animation
AOS.init();



// Menu for languages
$('#lang').smartmenus({
	mainMenuSubOffsetX: -45,
	mainMenuSubOffsetY: 20,
	//showOnClick: true,
	subIndicators: true,
	//subIndicatorsText: '<svg><use xlink:href="/svg-sprite/sprite/sprite.svg#lang_triang"></use></svg>',
});





// Popup
// Открываем попап с формой по клику
jQuery('.modal_open').click(function(e){
	e.preventDefault();
	jQuery('.modal_form').fadeIn(300).css('display', 'flex').addClass('active');
	jQuery('html').css('overflow', 'hidden');
});



// Закрываем попап по клику на иконку
jQuery('.close, .overlay').click(function(e) {
	e.preventDefault();
	clearFromErrors();
	clearFromFields()

	if (window.matchMedia("(max-width: 990px)").matches) {
		jQuery('#menu').hide();
	}
	jQuery('.toggle-mnu').removeClass('on');
	jQuery('#success').fadeOut(300);
	jQuery('.modal_form').fadeOut(300).removeClass('active');
	jQuery('html').css('overflow', '');
});


$(document).ready(function() {
	$("input:radio:checked").next('label').addClass("checked");
});



// Textarea
const textarea = document.querySelector('#m_message');
if (textarea) {
	textarea.addEventListener('keyup', function(e) {
		if (this.scrollTop > 0) {
			this.style.height = `${this.scrollHeight + 1}px`;
		}
		if (e.key === 'Delete' || e.key === 'Backspace') {
			this.style.height = '10px';
			this.style.height = `${this.scrollHeight + 1}px`;
		}
	});
}



// Collapse price table button
//$('[data-hidden="true"]').hide();

// $(document).ready(function() {
// 	var block = $('.block');
// 	var btn = $(block).find('.view_more');

// 	console.log(btn)

// 	$(block).each(function(i){
// 		$(btn).click(function(){
// 			// $('#toggle1-'+i).slideToggle('slow');
// 			// $('#toggle2-'+i).slideToggle('slow');

// 			$(block).find('.hidden').slideToggle(300, function() {
// 				if ($(this).is(':visible')) {
// 					link.find('span').text('View less')
// 					link.find('svg').addClass('open');
// 				} else {
// 					link.find('span').text('View More')
// 					link.find('svg').removeClass('open');
// 				}
// 			});
// 		});
// 	});
// });



var b1 = $('.block-1')
$(b1).find('.view_more').each(function(index) {
	$(this).on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		$(b1).find('.hidden').slideToggle(300, function() {
			if ($(this).is(':visible')) {
				link.find('span').text('View less')
				link.find('svg').addClass('open');
			} else {
				link.find('span').text('View More')
				link.find('svg').removeClass('open');
			}
		});
	})
});

var b2 = $('.block-2')
$(b2).find('.view_more').each(function(index) {
	$(this).on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		$(b2).find('.hidden').slideToggle(300, function() {
			if ($(this).is(':visible')) {
				link.find('span').text('View less')
				link.find('svg').addClass('open');
			} else {
				link.find('span').text('View More')
				link.find('svg').removeClass('open');
			}
		});
	})
});

var b3 = $('.block-3')
$(b3).find('.view_more').each(function(index) {
	$(this).on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		$(b3).find('.hidden').slideToggle(300, function() {
			if ($(this).is(':visible')) {
				link.find('span').text('View less')
				link.find('svg').addClass('open');
			} else {
				link.find('span').text('View More')
				link.find('svg').removeClass('open');
			}
		});
	})
});

var b4 = $('.block-4')
$(b4).find('.view_more').each(function(index) {
	$(this).on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		$(b4).find('.hidden').slideToggle(300, function() {
			if ($(this).is(':visible')) {
				link.find('span').text('View less')
				link.find('svg').addClass('open');
			} else {
				link.find('span').text('View More')
				link.find('svg').removeClass('open');
			}
		});
	})
});






// Google captcha
function onSubmit(token) {
	document.getElementById("fDestination").submit();
}

var review_recaptcha_widget;
var onloadCallback = function() {
	if($('#review_recaptcha').length) {
		review_recaptcha_widget = grecaptcha.render('review_recaptcha', {
			'sitekey' : 'KEY'
		});
	}
};




// $(function() {
//       $('#fDestination').submit(function(e) {
//       	alert('te');
//         var $form = $(this);
//         $.ajax({
//           type: $form.attr('method'),
//           url: $form.attr('action'),
//           data: $form.serialize()
//         }).done(function() {
//           console.log('success');
//         }).fail(function() {
//           console.log('fail');
//         });
//         //отмена действия по умолчанию для кнопки submit
//         e.preventDefault();
//       });
//     });




});



	// Получение данных с полей
	function getDataFrom(form) {
		const name = form.find('#name').val();
		const topic = form.find('#topic').val();
		const email = form.find('#email').val();
		const message = form.find('#message').val();
		return [{
			type: 'message',
			id: 'message',
			val: message,
		},
		{
			type: 'name',
			id: 'name',
			val: name
		},
		{
			type: 'topic',
			id: 'topic',
			val: topic
		},
		{
			type: 'email',
			id: 'email',
			val: email
		}
		];
	}




//var en = $('html').attr('lang') == 'en'
var key = $('html').attr('lang');
//console.log(key);

// Проверям форму на ошибки
function validate(formField) {
	const errMsg = {
		ru: {
			blank: "Обязательное поле",
			more: "Слишком короткое имя",
			emailInvalid: "Пожалуйста, введите корректный email",
		},

		en: {
			blank: "This field is necessary",
			more: "Please, add more",
			emailInvalid: "Please, enter a correct email",
		},

		ar: {
			blank: "هذا حقل مطلوب.",
			more: "يرجى إضافة المزيد",
			emailInvalid: "يرجى إدخال بريد إلكتروني صالح",
		},

		de: {
			blank: "Dies ist ein Pflichtfeld",
			more: "Bitte fügen Sie mehr hinzu",
			emailInvalid: "Bitte geben Sie eine gültige E-Mail-Adresse ein",
		},

		it: {
			blank: "Questo è un campo obbligatorio",
			more: "Per favore, aggiungi di più",
			emailInvalid: "Inserisci un indirizzo email valido",
		},

		fr: {
			blank: "Il s'agit d'un champ obligatoire",
			more: "Veuillez ajouter plus",
			emailInvalid: "Veuillez saisir un e-mail valide",
		},

		es: {
			blank: "Este es un campo obligatorio",
			more: "Por favor agregue más",
			emailInvalid: "Por favor ingrese un correo electrónico válido",
		}
	}
	const emailRegExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	switch (formField.type) {
		case 'name':
		if (formField.val === '') return {
			id: formField.id,
			errorMessage: errMsg[key].blank
		};
		if (formField.val.length <= 2) return {
			id: formField.id,
			errorMessage: errMsg[key].more
		};
		return false;

		case 'topic':
		if (formField.val === '') return {
			id: formField.id,
			errorMessage: errMsg[key].blank
		};
            // if (formField.val.length <= 2) return {
            //     id: formField.id,
            //     errorMessage: errMsg.more
            // };
            return false;
            case 'email':
            if (formField.val === '') return {
            	id: formField.id,
            	errorMessage: errMsg[key].blank
            };
            if (formField.val.length <= 2) return {
            	id: formField.id,
            	errorMessage: errMsg[key].more
            };
            if (emailRegExp.test(formField.val) == false) return {
            	id: formField.id,
            	errorMessage: errMsg[key].emailInvalid
            };
            return false;
        // case 'checkbox':
        //     if (!formField.val) return {
        //         id: formField.id,
        //         errorMessage: errMsg.more
        //     };
        //     return false;
        default:
        return false;
    }
}



// Показываю ошибки
function showErrors(errors) {
	errors.forEach(error => {
		const errorContainer = jQuery('#' + error.id).closest('.js--form-field');
		errorContainer.addClass('with-error');
		errorContainer.find('.js--error_message').text(error.errorMessage)
	});
}

// Очистка ошибок
function clearFromErrors() {
	jQuery('.js--error_message').text('');
	jQuery('.js--form-field').removeClass('with-error');
}

// Функция очистки полей
function clearFromFields() {
	const form_data = getDataFrom(jQuery('form'));
	form_data.forEach(function(fieldData) {
        //jQuery('#' + fieldData.id).prop("checked", false);
        //jQuery('#nda').prop("checked", false);
        //jQuery('#' + fieldData.id).val('');
        jQuery('#name, #email, textarea, #topic').val('').removeClass('has-content');
        //removeAttachedFiles();
    });
}



// Показываю попап успешной отправки
function showSuccessBlock() {
	jQuery("#success").fadeIn(300).css('display', 'flex').addClass('active');
	setTimeout(function() {
		clearFromFields();
		jQuery("#success").fadeOut(300).removeClass('active');
	}, 4000);
}



// Аякс отправка формы в футере
jQuery('#fForm input[type="submit"]').click(function (event) {
	event.preventDefault();
	clearFromErrors();
	var form = jQuery('#fForm');
	var form_data = getDataFrom(form);
	var errors = form_data.map(function (formField) {
		return validate(formField);
	}).filter(function (errorObject) {
		return errorObject;
	});
	if (errors.length > 0) {
		showErrors(errors);
	} else {
		showSuccessBlock();

		jQuery.ajax({
			url: form.attr('action'),
			method: 'POST',
			cache: false,
			dataType: "json",
			data: JSON.stringify(form_data),
			success: function(response) {
				if(response.result == 'success'){
					Swal.fire({
						text: form_feedback_text,
						icon: 'success'
					});
				}
			},
			error: function(response) {
				if (response.errors) {
					var errors = JSON.parse(response.errors)
					showErrors(errors.body);
				}
			}
		});
	}
});



	// Получение данных с полей
	function valid_destination_form(form) {
		var from_text = form.find('#from').val();
		var from_place = form.find('#from_place_id').val();
		var to_text = form.find('#to').val();
		var to_place = form.find('#to_place_id').val();
		var result = true;

		if(from_text === '' || from_place === ''){
			form.find('#from').parent('.form-group').addClass('has-error');
			form.find('#from').parent('.form-group').addClass('shake');
			result = false;
		}

		if(to_text === '' || to_place === ''){
			form.find('#to').parent('.form-group').addClass('has-error');
			form.find('#to').parent('.form-group').addClass('shake');
			result = false;
		}

		if(result === false){
			return false;
		}
	}


	// Аякс отправка формы
	jQuery('#fDestination input[type="submit"]').click(function (event) {
		event.preventDefault();

		var formf = jQuery('#fDestination');
		var form_valid = valid_destination_form(formf);

		if(form_valid === false){
			return;
		}

		formf.submit();

	});



	// Autocomplete
	$( 'body' ).on( 'input', '.autocomplete', function () {
		// let $_this = $( this );
		deleteAutocompleteResult();
	// window.appDelay( function () {
	// 	if ( !window.appLoading )
	// 		autocomplete( $_this );
	// }, 800 );
	});

	$( 'body' ).on( 'blur', '.autocomplete', function () {
	deleteAutocompleteResult()
	});

	$( 'body' ).on( 'change', '.autocomplete', function () {
	deleteAutocompleteResult()
	});

	function deleteAutocompleteResult () {
	$( 'body' ).find( '.autocomplete-result' ).fadeOut( 200, function () {
		$( this ).detach();
	});
	}

	function autocomplete ( $_this , direction) {
	let input = $_this.trim();

	$('#' + direction.id + '_place_id').val('');

	if ( input ) {

		$('.has-error').removeClass('has-error');
		$('.shake').removeClass('shake');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});


		grecaptcha.ready(function () {
			grecaptcha.execute(recaptcha_key, { action: 'validate_captcha' }).then(function (token) {
				var recaptchaResponse = document.getElementById('g-recaptcha-response');
				recaptchaResponse.value = token;

				jQuery.ajax({
					url: '/address?address=' + input,
					data: {
						'address' : input,
						'g_recaptcha_response': token
					},
					type: 'POST',
					success:function(data)
					{
						console.log(data);
						if(data.status === true){
							let list = '<div class="list-group autocomplete-result">';
							data.address.forEach( function ( item ) {
								list += '<a href="javascript://" class="list-group-item" data-place="'+ item.place_id + '">' + item.name  + '</a>';
							} );
							list += '</div>';

							$('#' + direction.id).parent().append( list);

							$( '.autocomplete-result a' ).bind( 'click', function () {
								$('#' + direction.id).val( $( this ).text() );
								$('#' + direction.id + '_place_id').val( $( this ).data('place') );
							} );

						}
					},
					error:function(data)
					{
						if(data.status === 422)
						{
							let response = data.responseJSON;
							if(response.g_recaptcha_response !== undefined && response.g_recaptcha_response[0] === 'false')
							{
								$('#recaptcha_error').show();
							}
						}
					}
				});
			});
		});

		// jQuery.ajax({
		// 	url: '/address?address=' + input,
		// 	data: {
		// 		'address' : input,
		// 		'g_recaptcha_response': recaptcha_key
		// 	},
		// 	type: 'POST',
		// success:function(data)
		// 	{
		// 		console.log(data);
		// 		if(data.status === true){
		// 			let list = '<div class="list-group autocomplete-result">';
		// 			data.address.forEach( function ( item ) {
		// 				list += '<a href="javascript://" class="list-group-item" data-place="'+ item.place_id + '">' + item.name  + '</a>';
		// 			} );
		// 			list += '</div>';
		//
		// 			$('#' + direction.id).parent().append( list);
		//
		// 			$( '.autocomplete-result a' ).bind( 'click', function () {
		// 				$('#' + direction.id).val( $( this ).text() );
		// 				$('#' + direction.id + '_place_id').val( $( this ).data('place') );
		// 			} );
		//
		// 		}
		// 	},
		// error:function(data)
		// 	{
		// 		if(data.status === 422)
		// 		{
		// 			let response = data.responseJSON;
		// 			// console.log(response);
		// 			// console.log(response.g_recaptcha_response);
		// 			console.log(response.g_recaptcha_response[0]);
		//
		// 			if(response.g_recaptcha_response !== undefined && response.g_recaptcha_response[0] === 'false')
		// 			{
		// 				grecaptcha.execute(recaptcha_key, {action:'validate_captcha'})
		// 					.then(function(token) {
		// 						// add token value to form
		// 						document.getElementById('g-recaptcha-response').value = token;
		// 					});
		// 			}
		//
		// 		}
		// 		console.log(data);
		//
		// 	}
		// });
	}
	}

	$(document).on('keyup', '#from', function() {
		var from = jQuery('#from').val();
		$('#recaptcha_error').hide();
		  if(from.length > 2){
			  autocomplete(from, this);
		  }
	});

	$(document).on('keyup', '#to', function() {
		var to = jQuery('#to').val();
		$('#recaptcha_error').hide();
		if(to.length > 2){
			autocomplete(to, this);
		}
	});



$(function() {

	$('.items a').on('click', function(e){
		e.preventDefault();
		let cargo_name = $(this).data('name');
        let form = $('#fCargo');
        form.find('input[name=pre_order_cargo]').val(cargo_name);
        form.submit();
	});
});











//
//
// // This example requires the Places library. Include the libraries=places
// // parameter when you first load the API. For example:
// // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
//
// function initMap() {
//   /* var map = new google.maps.Map(document.getElementById('map'), {
//     center: {lat: -33.8688, lng: 151.2195},
//     zoom: 13
// }); */
// var card = document.getElementById('pac-card');
// var input = document.getElementById('pac-input');
// var types = document.getElementById('type-selector');
// var strictBounds = document.getElementById('strict-bounds-selector');
//
// //  map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
//
// var autocomplete = new google.maps.places.Autocomplete(input);
//
//   // Bind the map's bounds (viewport) property to the autocomplete object,
//   // so that the autocomplete requests use the current map bounds for the
//   // bounds option in the request.
//   //autocomplete.bindTo('bounds', map);
//
//   // Set the data fields to return when the user selects a place.
//   autocomplete.setFields(
//   	['address_components', 'geometry', 'icon', 'name']);
//
//   /* var infowindow = new google.maps.InfoWindow();
//   var infowindowContent = document.getElementById('infowindow-content');
//   infowindow.setContent(infowindowContent);
//   var marker = new google.maps.Marker({
//     map: map,
//     anchorPoint: new google.maps.Point(0, -29) */
//   //});
//
//   autocomplete.addListener('place_changed', function() {
//   	infowindow.close();
//   	marker.setVisible(false);
//   	var place = autocomplete.getPlace();
//   	if (!place.geometry) {
//       // User entered the name of a Place that was not suggested and
//       // pressed the Enter key, or the Place Details request failed.
//       window.alert("No details available for input: '" + place.name + "'");
//       return;
//   }
//
//     // If the place has a geometry, then present it on a map.
//     if (place.geometry.viewport) {
//     	map.fitBounds(place.geometry.viewport);
//     } else {
//     	map.setCenter(place.geometry.location);
//       map.setZoom(17);  // Why 17? Because it looks good.
//   }
//   marker.setPosition(place.geometry.location);
//   marker.setVisible(true);
//
//   var address = '';
//   if (place.address_components) {
//   	address = [
//   	(place.address_components[0] && place.address_components[0].short_name || ''),
//   	(place.address_components[1] && place.address_components[1].short_name || ''),
//   	(place.address_components[2] && place.address_components[2].short_name || '')
//   	].join(' ');
//   }
//
//   infowindowContent.children['place-icon'].src = place.icon;
//   infowindowContent.children['place-name'].textContent = place.name;
//   infowindowContent.children['place-address'].textContent = address;
//   infowindow.open(map, marker);
// });
//
//   // Sets a listener on a radio button to change the filter type on Places
//   // Autocomplete.
//   function setupClickListener(id, types) {
//   	var radioButton = document.getElementById(id);
//   	radioButton.addEventListener('click', function() {
//   		autocomplete.setTypes(types);
//   	});
//   }
//
//   setupClickListener('changetype-all', []);
//   setupClickListener('changetype-address', ['address']);
//   setupClickListener('changetype-establishment', ['establishment']);
//   setupClickListener('changetype-geocode', ['geocode']);
//
//   document.getElementById('use-strict-bounds')
//   .addEventListener('click', function() {
//   	console.log('Checkbox clicked! New state=' + this.checked);
//   	autocomplete.setOptions({strictBounds: this.checked});
//   });
// }