$().ready(function(){
	$(".ctrl1").unbind("click").on('click', function(){
		console.log($("#password-input1").attr('type'));
		if($("#password-input1").attr('type') == 'password') {
			$(this).addClass('view');
			$('#password-input1').attr('type', 'text');
		}
		else {
			$(this).removeClass('view');
			$('#password-input1').attr('type', 'password');
		}
		return false;
	});
	$(".ctrl2").unbind("click").on('click', function(){
		if($("#password-input2").attr('type') == 'password') {
			$(this).addClass('view');
			$('#password-input2').attr('type', 'text');
		}
		else {
			$(this).removeClass('view');
			$('#password-input2').attr('type', 'password');
		}
		return false;
	});
	$(".ctrl3").unbind("click").on('click', function(){
		if($("#password-input3").attr('type') == 'password') {
			$(this).addClass('view');
			$('#password-input3').attr('type', 'text');
		}
		else {
			$(this).removeClass('view');
			$('#password-input3').attr('type', 'password');
		}
		return false;
	});

	$("#select_all").on('change', function() {
		if($(this).is(":checked")) {
			$(".property__item input").prop('checked', true);
		}
	});
});
