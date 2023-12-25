$(document).ready(function () {

	if($(".DataTableVehicle").length > 0){
		$(".DataTableVehicle").dataTable({
			isMobile: window.outerWidth < 800 ? true : false,
			responsive: window.outerWidth < 800 ? true : false, 
			"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
			ordering: !1,
			infoEmpty: 'No records',
			info: '_START_ -_END_ of _TOTAL_',
			"iDisplayLength": 10,
					language: {
				paginate: {
				next: '&#8594;', 
				previous: '&#8592;' 
				}
			}
		});


		$('.DataTableVehicle').delegate('#deleteVehicle', 'click', function(){
			var vehicle_id = $(this).attr('data-id');
			lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to delete this vehicle?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					ajax_data["vehicle_id"] = vehicle_id;
					$.ajax({
						type: 'POST',
						url: App_url +'agent/delete_vehicle',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							 }else{
								lnv.alert({
									content: 'Something went wrong!'
								});
							 }
						}
					}); 				
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			})
		});
	
	}
	
	if($(".DataTableTypes").length > 0){
		$(".DataTableTypes").dataTable({
			isMobile: window.outerWidth < 800 ? true : false,
			responsive: window.outerWidth < 800 ? true : false, 
			"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
			ordering: !1,
			infoEmpty: 'No records',
			info: '_START_ -_END_ of _TOTAL_',
			"iDisplayLength": 10,
					language: {
				paginate: {
				next: '&#8594;', 
				previous: '&#8592;' 
				}
			}
		});

		$(".DataTableTypes").delegate('#deleteVehiclePrice', 'click', function (e) {
			var price_id = $(this).attr('data-id');
			lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to delete this ?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					ajax_data["price_id"] = price_id;
					$.ajax({
						type: 'POST',
						url: App_url +'agent/delete_vehicle_price',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								lnv.alert({
									content: 'Something went wrong!'
								});
							}

						},
						error: function (request, status, error) {
							lnv.alert({
								content: error
							});
						}
					});					
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			});
		});

		$('#add-vehicle-price').click(function(){
			if($("#title").val() != '' 
			&&  $("#description").val() != '' 
			&&  $("#price_per_day").val() != '' 
			&&  $("#price_per_hour").val() != ''
			&&  $("#limit_mileage").val() != ''
			&&  $("#price_for_extra_mileage").val() != ''
			&&  $("#extra_hour_price").val() != ''){
				ajax_data["vehicle_id"] = $("#vehicle_id").val();
				ajax_data["vehicle_type_id"] = $("#vehicle_type_id").val();
				ajax_data["title"] = $("#title").val();
				ajax_data["description"] = $("#description").val();
				ajax_data["price_per_day"] = $("#price_per_day").val();
				ajax_data["price_per_hour"] = $("#price_per_hour").val();
				ajax_data["limit_mileage"] = $("#limit_mileage").val();
				ajax_data["price_for_extra_mileage"] = $("#price_for_extra_mileage").val();
				ajax_data["extra_hour_price"] = $("#extra_hour_price").val();
				$.ajax({
					type: 'POST',
					url: App_url +'agent/add_vehicle_price',
					data: ajax_data,
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							location.reload();
						}else{
							lnv.alert({
								content: 'Something went wrong!'
							});
						}

					},
					error: function (request, status, error) {
						lnv.alert({
							content: error
						});
					}
				});
			}else{
               $(".AjaxErrorHandler").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Please fill out all the fields<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}
		});


		$(".DataTableTypes").delegate('#deleteExtraOptions', 'click', function (e) {
			var extra_id = $(this).attr('data-id');
			lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to delete this ?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					ajax_data["extra_id"] = extra_id;
					$.ajax({
						type: 'POST',
						url: App_url +'agent/delete_extra',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								lnv.alert({
									content: 'Something went wrong!'
								});
							}
						},
						error: function (request, status, error) {
							lnv.alert({
								content: error
							});
						}
					});					
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			});
		});


		$('#add-extra-options').click(function(){
				ajax_data["vehicle_id"]  = $("#vehicle_id").val();
				ajax_data["price"]       = $("#price").val();
				ajax_data["type"]        = $("#type").val();
				ajax_data["title"]       = $("#title").val();
				ajax_data["description"] = $("#description").val();
				ajax_data["calculate"]   = $("#calculate").val();
				$.ajax({
					type: 'POST',
					url: App_url +'agent/add_extra_options',
					data: ajax_data,
					dataType  : 'json',
					success: function(response){
						if(response.type == "validation"){
							var errors = "";
							var x;
							for (x in response.message) {
								errors += response.message[x] + "<br>";
							}
							$(".AjaxErrorHandler").html('<div class="alert alert-warning  fade show" role="alert">'+errors+'</div>');
						}
						if(response.type == "success"){
							location.reload();
						}

					},
					error: function (request, status, error) {
						lnv.alert({
							content: error
						});
					}
				});
		});

		$(".DataTableTypes").delegate('#updateBooking', 'click', function (e) {
			var vehicle_booking_id = $(this).attr('data-id');
			lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to change this ?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					ajax_data["vehicle_booking_id"] = vehicle_booking_id;
					$.ajax({
						type: 'POST',
						url: App_url +'agent/update_booking',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								lnv.alert({
									content: 'Something went wrong!'
								});
							}
						},
						error: function (request, status, error) {
							lnv.alert({
								content: error
							});
						}
					});					
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			});
		});


	}

	$('form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13  && !$(document.activeElement).is('textarea')) { 
		  e.preventDefault();
		  return false;
		}
	});

	function readURL(input, i) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				i.img.attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$(document).delegate('.imageselector', 'change', function () {
		var i = {img: $(this).parent().parent().find('.img'),
			style: $(this).parent().parent().find('.img').css('width', '140px', 'height', '140px')
		};
		readURL(this, i);
	});

	$("body").delegate('#add-file-but', 'click', function (e) {
		e.preventDefault();
		var temp_html=`
			<div class="form-group">
				<div class="input-group">
					<img class="img rounded">
					<input type="file" name="image[]"  class="imageselector">
				</div>
			</div>
		`;
		$('#append').append(temp_html);
		$('.imageError').html('');
	}).delegate('#remove-file-but', 'click', function (e) {
		e.preventDefault();
		if($('#append .form-group').length > 1){
		  $('#append .form-group').last('.form-group').remove();
		}else{
			$('.imageError').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Please select atleast one image</div>');
		}
	});

	if($('.imageupload').length > 0){
		var $imageupload = $('.imageupload');
		$imageupload.imageupload();
	}


	if($("#delete_vehicle_images").length > 0){
		$('.image-container').delegate('#delete_vehicle_images', 'click', function(){ 
			var vehicle_id = $(this).attr('data-id');
			var vehicle_image = $(this).attr('data-image');
			lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to delete this ?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					ajax_data["vehicle_id"] = vehicle_id;
					ajax_data["vehicle_image"] = vehicle_image;
					$.ajax({
						type: 'POST',
						url: App_url +'agent/delete_vehicle_images',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								lnv.alert({
									content: 'Something went wrong!'
								});
							}

						},
						error: function (request, status, error) {
							lnv.alert({
								content: error
							});
						}
					});					
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			})
		});
	}
	
	if($(".select").length > 0){
		$(".select").select2({
			theme: "flat bordered"
		});
	}


		
	if($('#earnings_weekchart').length > 0){
		$.ajax({
		  url: App_url +"agent/get_earning_weekly_report",
		  method: "GET",
		  dataType: "json",
		  success: function(response) {
			Morris.Bar({
			  element: 'earnings_weekchart',
			  data: response.weekdata,
			  xkey: 'date',
			  ykeys: ['booking'],
			  labels: ['Amount(Rs)'],
			  barRatio: 0.4,
			  xLabelAngle: 35,
			  pointSize: 1,
			  barOpacity: 1,
			  pointStrokeColors:['#ff6028'],
			  behaveLikeLine: true,
			  grid: true,
			  gridTextColor:'#878787',
			  hideHover: 'auto',
			  smooth: true,
			  barColors: ['#736dea'],
			  resize: true,
			  gridTextFamily:"Roboto"
			});  
		  }
		});
	  }
 
	if($('#earnings_monthchart').length > 0){
		$.ajax({
			url: App_url +"agent/get_earning_monthly_report",
			method: "GET",
			dataType: "json",
			success: function(response) {
				Morris.Bar({
					element: 'earnings_monthchart',
					data: response.monthdata,
					xkey: 'date',
					ykeys: ['booking'],
					labels: ['Amount(Rs)'],
					barRatio: 0.4,
					xLabelAngle: 35,
					pointSize: 1,
					barOpacity: 1,
					pointStrokeColors:['#ff6028'],
					behaveLikeLine: true,
					grid: true,
					gridTextColor:'#878787',
					hideHover: 'auto',
					smooth: true,
					barColors: ['#736dea'],
					resize: true,
					gridTextFamily:"Roboto"
				});  
			}
		});
	}

	if($('#earnings_yearchart').length > 0){
		$.ajax({
		  url: App_url +"agent/get_earning_yearly_report",
		  method: "GET",
		  dataType: "json",
		  success: function(response) {
			Morris.Bar({
			  element: 'earnings_yearchart',
			  data: response.message.yeardata,
			  xkey: 'date',
			  ykeys: ['booking'],
			  labels: ['Amount(Rs)'],
			  barRatio: 0.4,
			  xLabelAngle: 35,
			  pointSize: 1,
			  barOpacity: 1,
			  pointStrokeColors:['#ff6028'],
			  behaveLikeLine: true,
			  grid: true,
			  gridTextColor:'#878787',
			  hideHover: 'auto',
			  smooth: true,
			  barColors: ['#736dea'],
			  resize: true,
			  gridTextFamily:"Roboto"
			});  
		  }
		});
	  }

	  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		switch (target) {
		  case "#earningsW":        
			$(window).trigger('resize');
			break;
		  case "#earningsM":        
			$(window).trigger('resize');
			break;
		  case "#earningsY":        
			$(window).trigger('resize');
			break;
		}
	  });

});