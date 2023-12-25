$(document).ready(function () {


	if($("#dataTBLElement").length > 0){
		$("#dataTBLElement").dataTable({
			isMobile: window.outerWidth < 800 ? true : false,
			responsive: window.outerWidth < 800 ? true : false, 
			"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
			"iDisplayLength": 10,
					language: {
				paginate: {
				next: '&#8594;', 
				previous: '&#8592;' 
				}
			}
		});
	}

	if($("#dataTBLElement").length > 0){
		$('#dataTBLElement').delegate('#selectAll', 'click', function(){
			if($(this).hasClass('checkedAll')) {
			$('input').prop('checked', false);   
			$(this).removeClass('checkedAll');
			} else {
			$('input').prop('checked', true);
			$(this).addClass('checkedAll');
			}
		});
	}
	var countChecked = function($table, checkboxClass) {
		if ($table) {
		var chkAll = $table.find(checkboxClass);
		var checked = chkAll.filter(':checked').length;
		var total = chkAll.length;    
		return {
			total: total,
			checked: checked
		}
		}
	}

	if($("#bulk_delete_vehicle_type").length > 0){
		$('#bulk_delete_vehicle_type').click(function(){ 
			var vehicle_type_id = []
			$("input[name='selected_id[]']:checked").each(function (){
				vehicle_type_id.push(parseInt($(this).val()));
			});
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
				},
				submitCallback: function () {
					ajax_data["vehicle_type_id"] = vehicle_type_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_vehicle_type_multiple',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($("#bulk_delete_locations").length > 0){
		$('#bulk_delete_locations').click(function(){ 
			var location_id = []
			$("input[name='selected_id[]']:checked").each(function (){
				location_id.push(parseInt($(this).val()));
			});
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
				},
				submitCallback: function () {
					ajax_data["location_id"] = location_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_location_multiple',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($("#bulk_delete_users").length > 0){
		$('#bulk_delete_users').click(function(){ 
			var user_id = []
			$("input[name='selected_id[]']:checked").each(function (){
				user_id.push(parseInt($(this).val()));
			});
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
				},
				submitCallback: function () {
					ajax_data["user_id"] = user_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_user_multiple',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($("#bulk_delete_blocking").length > 0){
		$('#bulk_delete_blocking').click(function(){ 
			var blocking_id = []
			$("input[name='selected_id[]']:checked").each(function (){
				blocking_id.push(parseInt($(this).val()));
			});
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
				},
				submitCallback: function () {
					ajax_data["blocking_id"] = blocking_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_block_multiple',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}


	if($("#close-select-tool").length > 0){
		$('#close-select-tool').click(function(){ 
			if($("#dataTBLElement").hasClass('checkedAll')) {
				$('input').prop('checked', true);
				$("#dataTBLElement").addClass('checkedAll');
			} else {
				$('input').prop('checked', false);   
				$("#dataTBLElement").removeClass('checkedAll');
			}
			$('.table-multi-select-tool').css({'opacity': '0', 'visibility' : 'hidden'});
		});
	}

	$(document).on('change', '.custom-control-input', function() {
		var result = countChecked($('#dataTBLElement'), '.custom-control-input');
		if(result.checked > 0){
			$('.table-multi-select-tool').css({'opacity': '1', 'visibility' : 'visible'});
			$('#selected-items').text(result.checked + " item selected");
		}else{
			$('.table-multi-select-tool').css({'opacity': '0', 'visibility' : 'hidden'});
		}
	});

	if($("#dataTBLElement").length > 0){
		$('#dataTBLElement').delegate('#vehicle_type_delete', 'click', function(){
			var vehicle_type_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
					notie.alert({
						type: 2,
						text: "shit",
						time: 0.5
					});
				},
				submitCallback: function () {
					ajax_data["vehicle_type_id"] = vehicle_type_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_vehicle_type',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($("#dataTBLElement").length > 0){
		$('#dataTBLElement').delegate('#location_delete', 'click', function(){
			var location_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["location_id"] = location_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_location',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($("#dataTBLElement").length > 0){
		$('#dataTBLElement').delegate('#user_delete', 'click', function(){
			var user_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["user_id"] = user_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_user',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		$('#dataTBLElement').delegate('#discount_delete', 'click', function(){
			var discount_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["discount_id"] = discount_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_discount',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		if($("#bulk_delete_discount").length > 0){
			$('#bulk_delete_discount').click(function(){ 
				var discount_id = []
				$("input[name='selected_id[]']:checked").each(function (){
					discount_id.push(parseInt($(this).val()));
				});
				new notie.confirm({
					type: 1,
					text: "Are You Sure You Want To Delete This ?",
					cancelCallback: function () {
					},
					submitCallback: function () {
						ajax_data["discount_id"] = discount_id;
						$.ajax({
							type: 'POST',
							url: App_url +'admin/delete_discount_multiple',
							data: ajax_data,
							dataType  : 'json',
							success: function(response){
								if(response.type == "success"){
									location.reload();
								}else{
									notie.alert({
										type: 2,
										text: response.message,
										time: 0.5
									});
								}
	
							},
							error: function (request, status, error) {
								notie.alert({
									type: 2,
									text: request.responseText,
									time: 0.5
								});
							}
						}); 
					}            
				});
			});
		}

		$('#dataTBLElement').delegate('#price_plan_delete', 'click', function(){
			var price_plan_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["price_plan_id"] = price_plan_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_price_plan',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		if($("#bulk_delete_price_plan").length > 0){
			$('#bulk_delete_price_plan').click(function(){ 
				var price_plan_id = []
				$("input[name='selected_id[]']:checked").each(function (){
					price_plan_id.push(parseInt($(this).val()));
				});
				new notie.confirm({
					type: 1,
					text: "Are You Sure You Want To Delete This ?",
					cancelCallback: function () {
					},
					submitCallback: function () {
						ajax_data["price_plan_id"] = price_plan_id;
						$.ajax({
							type: 'POST',
							url: App_url +'admin/delete_price_plan_multiple',
							data: ajax_data,
							dataType  : 'json',
							success: function(response){
								if(response.type == "success"){
									location.reload();
								}else{
									notie.alert({
										type: 2,
										text: response.message,
										time: 0.5
									});
								}
	
							},
							error: function (request, status, error) {
								notie.alert({
									type: 2,
									text: request.responseText,
									time: 0.5
								});
							}
						}); 
					}            
				});
			});
		}

		$('#dataTBLElement').delegate('#membership_delete', 'click', function(){
			var membership_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["membership_id"] = membership_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_membership',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		if($("#bulk_delete_memberships").length > 0){
			$('#bulk_delete_memberships').click(function(){ 
				var membership_id = []
				$("input[name='selected_id[]']:checked").each(function (){
					membership_id.push(parseInt($(this).val()));
				});
				new notie.confirm({
					type: 1,
					text: "Are You Sure You Want To Delete This ?",
					cancelCallback: function () {
					},
					submitCallback: function () {
						ajax_data["membership_id"] = membership_id;
						$.ajax({
							type: 'POST',
							url: App_url +'admin/delete_membership_multiple',
							data: ajax_data,
							dataType  : 'json',
							success: function(response){
								if(response.type == "success"){
									location.reload();
								}else{
									notie.alert({
										type: 2,
										text: response.message,
										time: 0.5
									});
								}
	
							},
							error: function (request, status, error) {
								notie.alert({
									type: 2,
									text: request.responseText,
									time: 0.5
								});
							}
						}); 
					}            
				});
			});
		}

		if($("#change_membership").length > 0){
			$('#dataTBLElement').delegate('#change_membership', 'click', function(){
				var user_id = $(this).attr('data-id');
				$('#modalSlideLeft').find('input[name=update_id]').val(user_id);
				$('#modalSlideLeft').modal('show');
			});

			$('#update_membership').click(function(){
				var membership_id = $('#modalSlideLeft').find('.modal-body input:checked').val();
				var user_id       = $('#modalSlideLeft').find('input[name=update_id]').val();
				ajax_data["membership_id"] = membership_id;
				ajax_data["user_id"] = user_id;
				$.ajax({
					type: 'POST',
					url: App_url +'admin/change_membership',
					data: ajax_data,
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							location.reload();
						}else{
							notie.alert({
								type: 2,
								text: response.message,
								time: 0.5
							});
						}

					},
					error: function (request, status, error) {
						notie.alert({
							type: 2,
							text: request.responseText,
							time: 0.5
						});
					}
				}); 
			});

		}

		$('#dataTBLElement').delegate('#extra_delete', 'click', function(){
			var extra_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["extra_id"] = extra_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_extra',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});




	}

	if($("#dataTBLElement").length > 0){
		$('#dataTBLElement').delegate('#blocking_delete', 'click', function(){
			var blocking_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["blocking_id"] = blocking_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_blocking',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});
	}

	if($('#DTVehicles').length > 0){
		$('#DTVehicles').DataTable({
			isMobile: window.outerWidth < 800 ? true : false,
			responsive: window.outerWidth < 800 ? true : false, 
			language: {
				paginate: {
				  next: '&#8594;', 
				  previous: '&#8592;' 
				}
			},
			"processing": true, 
			"serverSide": true, 
			"ordering": false,
			"ajax": {
				"url": App_url +"admin/vehicle_list",
				"type": "POST",
				"data": function (data) {
					data.location_id = $('#location_id').val();
					data.start_date = $('#start_date').val();
					data.end_date   = $('#end_date').val();
					data[CSRF_NAME] =  CSRF_HASH;
				}
			},
			"columnDefs": [{ 
				"targets": [ 0 ], 
				"orderable": false
			},
			{
				"targets": [0], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					return  '<div class="custom-control custom-checkbox">'+
							'<input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_'+data+'" value="'+data+'"></input>'+
							'<label class="custom-control-label" for="selected_id_'+data+'"></label>'+
					        '</div>';
				}
			},
			{
				"targets": [1], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					return  '<a  href="'+App_url+'frontend/images/vehicles/'+data+'" data-lightbox="'+data+'"><img alt="'+data+'" src="'+App_url+'frontend/images/vehicles/'+data+'" data-lightbox="'+data+'" class="rounded" style="width:35px"></a>';
					//return  '<a  href="'+App_url+'frontend/images/vehicles/'+data+'" data-lightbox="'+data+'" class="rounded" style="width:35px">'+data+'</a>';

				}
			},
			{
				"targets": [4], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					var currentClass = (data == 1)? "primary" : "default";
					var statusText = (data == 1)? "Active" : "Pending";
					return  '<span class="badge badge-'+currentClass+'">'+statusText+'</span>';
				}
			},
			{
				"targets": [5], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					return  '<a href="'+App_url+'admin/update_vehicle/'+data+'" class="btn btn-sm btn-primary mr-2">Edit</a>'+
                         	'<a href="'+App_url+'admin/update_vehicle_status/'+data+'" class="btn btn-sm btn-white mr-2">Status</a>'+
							'<button type="button" class="btn btn-sm btn-light" id="vehicle_delete" data-id="'+data+'">Delete</button>';
				}
			},
		]
		});

		$('#applyVehicles').click(function(){ 
			$('#DTVehicles').DataTable().ajax.reload(); 
		});

		$('#resetVehicles').click(function(){ 
			$('#start_date').val("")
			$('#end_date').val("");
			$('#location_id').val("");
			$('#DTVehicles').DataTable().ajax.reload(); 
		});

		$('#DTVehicles').delegate('#selectAll', 'click', function(){
			if($(this).hasClass('checkedAll')) {
			  $('input').prop('checked', false);   
			  $(this).removeClass('checkedAll');
			} else {
			  $('input').prop('checked', true);
			  $(this).addClass('checkedAll');
			}
		});


		$(document).on('change', '.custom-control-input', function() {
			var result = countChecked($('#DTVehicles'), '.custom-control-input');
			if(result.checked > 0){
				$('.table-multi-select-tool').css({'opacity': '1', 'visibility' : 'visible'});
				$('#selected-items').text(result.checked + " item selected");
			}else{
				$('.table-multi-select-tool').css({'opacity': '0', 'visibility' : 'hidden'});
			}
		});

		$('#DTVehicles').delegate('#vehicle_delete', 'click', function(){
			var vehicle_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["vehicle_id"] = vehicle_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_vehicle',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		if($("#bulk_delete_vehicle").length > 0){
			$('#bulk_delete_vehicle').click(function(){ 
				var vehicle_id = []
				$("input[name='selected_id[]']:checked").each(function (){
					vehicle_id.push(parseInt($(this).val()));
				});
				new notie.confirm({
					type: 1,
					text: "Are You Sure You Want To Delete This ?",
					cancelCallback: function () {
					},
					submitCallback: function () {
						ajax_data["vehicle_id"] = vehicle_id;
						$.ajax({
							type: 'POST',
							url: App_url +'admin/delete_vehicle_multiple',
							data: ajax_data,
							dataType  : 'json',
							success: function(response){
								if(response.type == "success"){
									location.reload();
								}else{
									notie.alert({
										type: 2,
										text: response.message,
										time: 0.5
									});
								}
	
							},
							error: function (request, status, error) {
								notie.alert({
									type: 2,
									text: request.responseText,
									time: 0.5
								});
							}
						}); 
					}            
				});
			});
		}

		
	
	}
	

	if($('#DTBooking').length > 0){
		$('#DTBooking').DataTable({
			isMobile: window.outerWidth < 800 ? true : false,
			responsive: window.outerWidth < 800 ? true : false, 
			language: {
				paginate: {
				  next: '&#8594;', 
				  previous: '&#8592;' 
				}
			},
			"processing": true, 
			"serverSide": true, 
			"ordering": false,
			"ajax": {
				"url": App_url +"admin/booking_list",
				"type": "POST",
				"data": function (data) {
					data.location_id = $('#location_id').val();
					data.start_date = $('#start_date').val();
					data.end_date   = $('#end_date').val();
					data.agent_id   = $('#agent_id').val();
					data[CSRF_NAME] =  CSRF_HASH;
				}
			},
			"columnDefs": [{ 
				"targets": [ 0 ], 
				"orderable": false
			},
			{
				"targets": [0], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					return  '<div class="custom-control custom-checkbox">'+
							'<input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_'+data+'" value="'+data+'"></input>'+
							'<label class="custom-control-label" for="selected_id_'+data+'"></label>'+
					        '</div>';
				}
			},
			{
				"targets": [4], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					var currentClass = (data == "confirmed")? "primary" : "default";
					var statusText = (data == "confirmed")? "Confirmed" : "Pending";
					return  '<span class="badge badge-'+currentClass+'">'+statusText+'</span>';
				}
			},
			{
				"targets": [5], 
				"orderable": false,
				"render": function ( data, type, row, meta ) {
					return  '<a href="'+App_url+'admin/get_booking_details/'+data+'" class="btn btn-sm btn-primary mr-2">View</a>'+
                         	'<a href="'+App_url+'admin/update_booking_status/'+data+'" class="btn btn-sm btn-white mr-2">Status</a>'+
							'<button type="button" class="btn btn-sm btn-light" id="booking_delete" data-id="'+data+'">Delete</button>';
				}
			},
		],
		"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;  
			   var intVal = function ( i ) {
				   return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 :typeof i === 'number' ? i : 0;
			   };
			   
			 netprofit = api.column(3).data().reduce( function (a, b) {
				  return intVal(a) + intVal(b);
			  }, 0 );
			  
			  $('#totalAmount').text(netprofit);

			  
		},
		  
		});

		$('#applyBooking').click(function(){ 
			$('#DTBooking').DataTable().ajax.reload(); 
		});

		$('#resetBooking').click(function(){ 
			$('#start_date').val("")
			$('#end_date').val("");
			$('#location_id').val("");
			$('#agent_id').val("");
			$('#DTBooking').DataTable().ajax.reload(); 
		});

		$('#DTBooking').delegate('#selectAll', 'click', function(){
			if($(this).hasClass('checkedAll')) {
			  $('input').prop('checked', false);   
			  $(this).removeClass('checkedAll');
			} else {
			  $('input').prop('checked', true);
			  $(this).addClass('checkedAll');
			}
		});


		$(document).on('change', '.custom-control-input', function() {
			var result = countChecked($('#DTBooking'), '.custom-control-input');
			if(result.checked > 0){
				$('.table-multi-select-tool').css({'opacity': '1', 'visibility' : 'visible'});
				$('#selected-items').text(result.checked + " item selected");
			}else{
				$('.table-multi-select-tool').css({'opacity': '0', 'visibility' : 'hidden'});
			}
		});


		$('#DTBooking').delegate('#booking_delete', 'click', function(){
			var booking_id = $(this).attr('data-id');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {

				},
				submitCallback: function () {
					ajax_data["booking_id"] = booking_id;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_booking',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 
				}            
			});
		});

		if($("#bulk_delete_booking").length > 0){
			$('#bulk_delete_booking').click(function(){ 
				var booking_id = []
				$("input[name='selected_id[]']:checked").each(function (){
					booking_id.push(parseInt($(this).val()));
				});
				new notie.confirm({
					type: 1,
					text: "Are You Sure You Want To Delete This ?",
					cancelCallback: function () {
					},
					submitCallback: function () {
						ajax_data["booking_id"] = booking_id;
						$.ajax({
							type: 'POST',
							url: App_url +'admin/delete_booking_multiple',
							data: ajax_data,
							dataType  : 'json',
							success: function(response){
								if(response.type == "success"){
									location.reload();
								}else{
									notie.alert({
										type: 2,
										text: response.message,
										time: 0.5
									});
								}
	
							},
							error: function (request, status, error) {
								notie.alert({
									type: 2,
									text: request.responseText,
									time: 0.5
								});
							}
						}); 
					}            
				});
			});
		}
	
	}
	

    if($("#start_date").length > 0){
        var picker = new Lightpick({
            field: document.getElementById('start_date'),
            secondField: document.getElementById('end_date'),
            singleDate: false,
            format : "YYYY-MM-DD"
        });
	}
	
	if($("#from").length > 0){
        var picker = new Lightpick({
            field: document.getElementById('from'),
            secondField: document.getElementById('to'),
            singleDate: false,
            format : "YYYY-MM-DD"
        });
	}

	if($("#delete_vehicle_images").length > 0){
		$('.image-container').delegate('#delete_vehicle_images', 'click', function(){ 
			var vehicle_id = $(this).attr('data-id');
			var vehicle_image = $(this).attr('data-image');
			new notie.confirm({
				type: 1,
				text: "Are You Sure You Want To Delete This ?",
				cancelCallback: function () {
				},
				submitCallback: function () {
					ajax_data["vehicle_id"] = vehicle_id;
					ajax_data["vehicle_image"] = vehicle_image;
					$.ajax({
						type: 'POST',
						url: App_url +'admin/delete_vehicle_images',
						data: ajax_data,
						dataType  : 'json',
						success: function(response){
							if(response.type == "success"){
								location.reload();
							}else{
								notie.alert({
									type: 2,
									text: response.message,
									time: 0.5
								});
							}

						},
						error: function (request, status, error) {
							notie.alert({
								type: 2,
								text: request.responseText,
								time: 0.5
							});
						}
					}); 

				}            
			});
		});
	}

	if($(".select").length > 0){
		$(".select").select2({
			theme: "flat bordered"
		});
	}

	if($(".rvehicle").length > 0){
		$(".rvehicle").on("change", function () {
			if($(this).val() != "0"){
				ajax_data["vehicle_type"] = $(this).val();
				$.ajax({
					type: 'POST',
					url: App_url +'admin/get_vehicle_type',
					data: ajax_data,
					dataType  : 'json',
					success: function(response){
						if(response.message != ''){
							$('#vehicle').empty();
							$.each(response.message, function(key, value) {
								$('#vehicle').append('<option value="'+ key +'">'+ value +'</option>');
							});
					    }else{
							$('#vehicle').empty();
							$('#vehicle').append('<option value="">--Select Vehicle--</option>');
						}
					},
					error: function (request, status, error) {
						notie.alert({
							type: 2,
							text: request.responseText,
							time: 0.5
						});
					}
				}); 

			}else{
				notie.alert({
					type: 2,
					text: "Please select a vehicle type",
					time: 0.5
				});
			}
		});

		if($(".typeUpdate").length > 0){
			ajax_data["vehicle_type"] = $(".typeUpdate").val();
			$.ajax({
				type: 'POST',
				url: App_url +'admin/get_vehicle_type',
				data: ajax_data,
				dataType  : 'json',
				success: function(response){
					$('#vehicle').empty();
					$.each(response.message, function(key, value) {
						$('#vehicle').append('<option value="'+ key +'">'+ value +'</option>');
					});
				},
				error: function (request, status, error) {
					notie.alert({
						type: 2,
						text: request.responseText,
						time: 0.5
					});
				}
			});
		}


	}
		
	if($('#revenue_chart').length > 0){
		$.ajax({
			url: App_url +"admin/get_revenue_report",
			method: "GET",
			dataType: "json",
			success: function(response) {
				Morris.Bar({
					element: 'revenue_chart',
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

	if($('#calendar').length > 0){
		$('#calendar').fullCalendar({
		
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			droppable: false,
			eventLimit: true,
			eventTextColor: '#fff',
		events: {
				url: App_url+'admin/get_calendar_events',
				type: 'GET',
				error: function(err) {
					console.log('Error!- This request could not be completed' + err);
				},
				success: function(response) {

				},
		},
		eventMouseover: function (data, event, view) {
			$(this).popover({
				trigger:'hover',
				title: data.title,
				container:"body",
				placement:'auto',
				animation: true,
				html: true,  
				content: function () {
					return '<div class="col-xs-3"><h5 class="popover-content-date-month">Pickup</h5><p class="popover-content-description text-success">'+data.pickup+'</p><h5 class="popover-content-date-month">Drop Off</h5><p class="popover-content-description text-warning">'+data.drop+'</p></div><div class="col-xs-9 pb-10"></div>';
				}
			});

		},
		
		});
    }
	
});