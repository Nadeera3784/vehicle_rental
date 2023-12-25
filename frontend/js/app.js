$(document).ready(function () {
	$(this).scrollTop(0);

	$(window).scroll(function () {
		let scroll = $(window).scrollTop();
		if (scroll >= 125) {
			$('.navbar').addClass('scrollable-header');
		} else {
			$('.navbar').removeClass('scrollable-header');
		}
	});
	
	if($(".center").length > 0){
		$(".center").slick({
			dots: true,
			infinite: true,
			centerMode: true,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint:600,
					settings: {
						mobileFirst: true,
						slidesToShow: 1,
					}
				}
			]
		});
	}
	
	if($('#pickup_date').length > 0 &&  $('#drop_date').length > 0 && $('#drop_time').length > 0){
		flatpickr("#pickup_date", {
			minDate: new Date(),
			dateFormat : App_date_format,
			onChange: function onChange(selectedDates, dateStr) {
				var tmpDate = new Date(selectedDates);
				flatpickr("#drop_date").set('minDate', tmpDate);
				//flatpickr("#drop_date").setDate(tmpDate.fp_incr(1), true);
				var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()).getTime();
				var selected = tmpDate.getTime();

				if (today >= selected) {
					$('#drop_time').timepicker('remove');
					$('#pickup_time').timepicker('remove');
					$('#drop_time').timepicker({'minTime': new Date(), 'timeFormat': App_time_format});
					$('#pickup_time').timepicker({'minTime': new Date(), 'timeFormat': App_time_format});
				} else {
					$('#drop_time').timepicker('remove');
					$('#pickup_time').timepicker('remove');
					$('#drop_time').timepicker({'timeFormat': App_time_format});
					$('#pickup_time').timepicker({'timeFormat': App_time_format});
				}
			}
		});

		flatpickr("#drop_date", {
			dateFormat : App_date_format,
			minDate: new Date(),
			onChange: function onChange(selectedDates, dateStr) {
				var tmpDate = new Date(dateStr);
				flatpickr("#pickup_date").set('maxDate', tmpDate);
				//flatpickr("#drop_date").setDate(tmpDate.fp_incr(1), true);
				var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()).getTime();
				var selected = tmpDate.getTime();


				if (today >= selected) {
					$('#drop_time').timepicker('remove');
					$('#drop_time').timepicker({'minTime': new Date(), 'timeFormat': App_time_format});
				} else {
					$('#drop_time').timepicker('remove');
					$('#drop_time').timepicker({'timeFormat': App_time_format});
				}
			}
		});

		var pickup = document.querySelector("#pickup_date")._flatpickr;
		pickup.setDate(pickup.selectedDates);
		var FormatedPickUpDate = new Date(pickup.selectedDates);
		var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()).getTime();
		var pickupDate = FormatedPickUpDate.getTime();

		
		var drop = document.querySelector("#drop_date")._flatpickr;
		drop.setDate(pickup.selectedDates);
		var FormatedDropDate = new Date(drop.selectedDates);
		var returnDate = FormatedDropDate.getTime();

		if (today >= pickupDate) {
			$('#pickup_time').timepicker({'minTime': new Date(), 'timeFormat': App_time_format});
		} else {
			$('#pickup_time').timepicker({'timeFormat': App_time_format});
		}
		
		if (today >= returnDate) {
			$('#drop_time').timepicker({'minTime': new Date(), 'timeFormat': App_time_format});
		} else {
			$('#drop_time').timepicker({'timeFormat': App_time_format});
		}



	}
	
	$('#option_form').delegate('input[name^=extra]', 'click', function(event){
		var $button_id = $(this).attr('id');
		var $feauture_price = $(this).attr('data-price');
		var $feauture_real_id = $(this).attr('data-id');
		var $feauture_title = $(this).attr('data-title');
		var $feauture_id = $(this).attr('id');
		var optionForm = $('#option_form');

		if($(this).parent().parent().parent().hasClass('active')){
			$(this).parent().parent().parent().toggleClass('active');
			$('.extra-feautures li[id="'+$button_id+'"]').remove();
			$('.extra-options input[id="'+$button_id+'"]').remove();
		}else{
			$(this).parent().parent().parent().toggleClass('active');
			var $html_template =  "<li id='"+$feauture_id+"'>"+$feauture_title+"<span>"+App_currency+""+$feauture_price+"</span></li>";
			$(".extra-feautures").append($html_template);
			var $html_template_2 =  "<input id='"+$feauture_id+"' data-price="+$feauture_price+" value='"+$feauture_real_id+"' type='hidden' name='extra_id["+$feauture_real_id+"]'/>";
			$(".extra-options").append($html_template_2);
		}

		$.ajax({
			type: 'POST',
			url: App_url +'app/calculate_Price',
			data: optionForm.serialize(),
			dataType  : 'json',
			success: function(response){
				if ($("#price").length > 0) {
					$("#price").text(response.formated_car_price);
				}
				if ($("#tax").length > 0) {
					$("#tax").text(response.formated_tax);
				}
				if ($("#discount").length > 0) {
					$("#discount").text(response.formated_discount);
				}
				if ($("#extra").length > 0) {
					$("#extra").text(response.formated_extra_price);
				}
				if ($("#total").length > 0) {
					$("#total").text(response.formated_total);
					$(".price-big").text(response.total);
					$(".totalamount").val(response.total);
				}
			},
			error: function (request, status, error) {
				console.log(error);
			}
		});
	});

	$(document).on('click', '#ui_model__icon', function() {
		$('.ui_model__popup').addClass('opened');
		$('body').addClass('fancy-lock');
		$(".fixed-top").css({zIndex: 0 });
	});

	$(document).on('click', '.ui_model__close', function() {
		$('.ui_model__popup').removeClass('opened');
		$('body').removeClass('fancy-lock');
		$(".fixed-top").css({zIndex: 1030 });
	});

	if($("#itemContainer").length > 0){
		$("div.holder").jPages({
			containerID : "itemContainer",
			perPage : 5,
			next : "Next",
			previous : "Previous"
		  });
	}
	
	$("#filterContainer, .ui_model__inner_container").delegate(".checkbox-filter", "click", function (e) {
		e.stopImmediatePropagation();

		var filterForm = $("#filter-form");

		$.ajax({
			type: "POST",
			data: filterForm.serialize(),
			url: App_url +'app/get_filter_vehicles',
			beforeSend: function() {
			},
			success: function (response) {
				$("#vehicle-loop").html(response);
			},
			complete : function(e){
				$("div.holder").jPages({
					containerID : "itemContainer",
					perPage : 5,
					next : "Next",
					previous : "Previous"
				});
			}
		});
	});

	var e = $(window) , 
	a = $("body") ,
	 o = $(document);
	
	function i() {
	  return e.width()
	}
	
	var n = i();
	e.on("resize", function() {
	  n = i()
	});
	
	function w(t) {
		n < 991 ? t.delay(500).addClass("navbar-mobile") : t.delay(500).removeClass("navbar-mobile")
	}
	
	w($(".navbar_second"));
	e.on("resize", function() {
		w($(".navbar_second"))
	});

	
	$(document).on('click', '#dashboard-nav', function(e) {
		e.preventDefault();
		$('.navbar_second').toggleClass("active"); 
	});

	let toggle_initialized = false;
    let navbar_menu_visible = 0;

	$(document).on('click', '.navbar-toggler', function() {
		$toggle = $(this);
		if (navbar_menu_visible == 1) {
			$('html').removeClass('nav-open');
			navbar_menu_visible = 0;
			$('#bodyClick').remove();
			setTimeout(function() {
				$toggle.removeClass('toggled');
			}, 550);
		} else {
			setTimeout(function() {
				$toggle.addClass('toggled');
			}, 580);
			div = '<div id="bodyClick"></div>';
			$(div).appendTo('body').click(function() {
				$('html').removeClass('nav-open');
				navbar_menu_visible = 0;
				setTimeout(function() {
					$toggle.removeClass('toggled');
					$('#bodyClick').remove();
				}, 550);
			});

			$('html').addClass('nav-open');
			navbar_menu_visible = 1;
		}
	});

	if($(".slider1").length > 0){
		$('.slider1').slick({
			responsive: [
				{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				}
				},
				{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
				},
				{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
				}
			],
			slidesToShow: 1,
			arrows : false,
			autoplay : true,
			adaptiveHeight: false
		});
	}

	
	if($(".vehicle-gallery").length > 0){
		$('.vehicle-gallery').slick({
			responsive: [
				{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				}
				},
				{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
				},
				{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
				}
			],
			slidesToShow: 1,
			arrows : true,
			autoplay : true,
			adaptiveHeight: false
		});
	}

	if($("#searchForm").length > 0){
		$("#searchForm").validate();
	}

	if($("#paymentForm").length > 0){
		$("#paymentForm").validate();
	}

});



