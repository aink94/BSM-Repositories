$(function () {
	
	$('button#sign').click(function () {
		$.ajax({
			context : {
				"context" : "form"
			},
			type    : "POST",
			url     : "/login",
			dataType: 'json',
			data    : {
				'username'  : $('input[name="username"]').val(),
				'password'  : $('input[name="password"]').val()
			}
		})
		.done(function(request, textStatus, errorThrown){
			window.location.replace(request.intended);//location.reload(request);
		});
	});
});