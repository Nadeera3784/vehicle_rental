$(document).ready(function () {

	jQuery('.scrollbar-macosx').scrollbar();

	$('.toggle-side-nav').on('click', function () {
		$('.side-nav').toggleClass('show-side-nav');
		$('.toggle-side-nav').toggleClass('show-side-nav');
	});

	$('.reveal-side-canva').on('click', function () {
		$('.side-canva').addClass('show-side-canva');
	});

	$('.close-side-canva').on('click', function (e) {
		e.preventDefault();
		$('.side-canva').removeClass('show-side-canva');
	});
	
	var _notifsTray = $('.notifications-tray');
	$('.show-notifs').on('click', function (e) {
		e.preventDefault();
		_notifsTray.removeClass('reveal-notifs');
		$(this).parent().addClass('reveal-notifs');
		e.stopImmediatePropagation();
	});


	$('.drop-link').on('click', function (event) {
		$('.drop-menu').addClass('show-drop');
		event.stopImmediatePropagation();
	});
	var modal = document.querySelector(".drop-menu");

	var closeMenu =function (event) {
		if ((event.target !== modal) && $('.drop-menu').hasClass('show-drop')) {
			$('.drop-menu').removeClass('show-drop');
		}
		if ((event.target !== _notifsTray) && _notifsTray.hasClass('reveal-notifs')) {
			_notifsTray.removeClass('reveal-notifs');
		}
	};
	window.addEventListener("click", closeMenu);
    
	
	var sidebar = $('.sidebar');
    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      if (current === "") {
        if ($this.attr('href').indexOf("index.html") !== -1) {
			console.log(current);
          $(this).parents('.nav-item').last().addClass('active');
          if ($(this).parents('.sub-menu').length) {
            $(this).closest('.collapse').addClass('show');
            $(this).addClass('active');
          }
        }
      } else {
        if ($this.attr('href').indexOf(current) !== -1) {
          $(this).parents('.nav-item').last().addClass('active');
          if ($(this).parents('.sub-menu').length) {
            $(this).closest('.collapse').addClass('show');
            $(this).addClass('active');
          }
        }
      }
    })

	sidebar.on('show.bs.collapse', '.collapse', function() {
		sidebar.find('.collapse.show').collapse('hide');
	  });



	// $('.dataTables-Element').delegate('#emp_delete', 'click', function(){
    //     Swal.fire({
	// 			  title: 'Are you sure?',
	// 			  text: 'You will not be able to recover this imaginary file!',
	// 			  type: 'warning',
	// 			  showCancelButton: true,
	// 			  confirmButtonText: 'Yes, delete it!',
	// 			  cancelButtonText: 'No, keep it'
	// 	}).then((result) => {
	// 		if (result.value) {
	// 			Swal.fire(
	// 			  'Deleted!',
	// 			  'Your imaginary file has been deleted.',
	// 			  'success'
	// 			)
	// 		} else if (result.dismiss === Swal.DismissReason.cancel) {
	// 	    Swal.fire(
	// 	      'Cancelled',
	// 	      'Your imaginary file is safe :)',
	// 	      'error'
	// 	    )
	// 	}
	// 	})
	// });

	
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

});

