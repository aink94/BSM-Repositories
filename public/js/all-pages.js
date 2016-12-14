var modal = '' +
        '<div id="modal" class="modal modal" role="dialog" tabindex="-1" aria-labelledby="" aria-hidden="true">'+
        '<div class="modal-dialog">'+
        '<div class="modal-content">'+
        '<div class="modal-header">'+
        '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
        '<h4 class="modal-title"></h4>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '</div>';

var rfidform = ''+
	'<form>'+
	'<div class="modal-body icon-rfid">'+
	'<center>'+
	'<img src="assets/img/scan-rfid.gif">'+
	'</center>'+
	'</div>'+
	'</form>';

var NOTIF = (function(){
	function notif(){}

	notif.show = function(params){
		var img;
		if(typeof params.type !== "undefined"){
			switch (params.type){
				case "error":
					img = "assets/img/error.png";
				break;
				case "success" :
					img = "assets/img/success.png";
				break;
				case "warning" :
					img = "assets/img/warning.png";
				break;
			}	
		}
		$.gritter.add({
			title      : params.title || params.type || "Notification",
			text       : params.message || "Message",
			image      : img || "assets/img/error.png",
			sticky     : params.sticky || false,
			time       : params.delay || '5000',
			class_name : params.class || 'my-sticky-class'
		});
	}

	return notif;
})($);

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ajaxStart(onStart)
	.ajaxStop(onStop)
	.ajaxSend(onSend)
	.ajaxComplete(onComplete)
	.ajaxSuccess(onSuccess)
	.ajaxError(onError);

function onStart(event, settings){
	//console.log("Start Global =========================================");
	//console.log('------ # Event   # ------');
	//console.log(event);
	//console.log('------ # Setting # ------');
	//console.log(settings);
}

function onStop(event){
	//console.log("Stop Global =========================================");
	//console.log('------ # Event   # ------');
	//console.log(event);

}

function onSend(event, xhr, settings){
	//console.log("Send Global =========================================");
	//console.log('------ # Event   # ------');
	//console.log(event);
	//console.log('------ # jqXHR   # ------');
	//console.log(xhr);
	//console.log('------ # Setting # ------');
	//console.log(settings);

	if(typeof settings.context !== 'undefined'){
		switch (settings.context.context) {
			case "form" :
				$('.loading').show();
			break;
			case "table" :
				$('.loading').show();
			break;
			case "rfid" :
				$('body').append(modal);
				if($('form').length == 0) {
					$('.modal-content').append(rfidform);
				}
				$('.modal-title').text(settings.context.title+" Nasabah");
				$('#modal').modal({keyboard: false, backdrop: 'static'});
			break;
		}
	}
}

function onComplete(event, xhr, settings){
	//console.log("Complete Global =====================================");
	//console.log('------ # Event   # ------');
	//console.log(event);
	//console.log('------ # jqXHR   # ------');
	//console.log(xhr);
	//console.log('------ # Setting # ------');
	//console.log(settings);
	if(typeof settings.context !== "undefined"){
		switch (settings.context.context) {
			case "form" :
				$('.loading').hide();
			break;
			case "rfid" :

			break;
			case "table" :
				$('.loading').hide();
			break;
		}
	}
}

function onSuccess(event, xhr, settings){
	//console.log("Success Global ======================================");
	//console.log('------ # Event   # ------');
	//console.log(event);
	//console.log('------ # jqXHR   # ------');
	//console.log(xhr);
	//console.log('------ # Setting # ------');
	//console.log(settings);
	if(typeof settings.context !== "undefined"){
		switch (settings.context.context){
			case "form" :
				$('.loading').hide();
            	$("#modal").modal("hide");

            	NOTIF.show({
            		type    : "success",
            		title   : xhr.responseJSON.title,
					message : xhr.responseJSON.message
				});
			break;
			case "table" :
				$('.loading').hide();
			break;
			case "rfid":
				NOTIF.show({
            		type    : "success",
            		title   : xhr.responseJSON.title,
					message : xhr.responseJSON.message
				});
			break;
		}
	}
}

function onError(event, xhr, settings, thrownError){
	//console.log("Error Global =========================================");
	//console.log('------ # Event   # ------');
	//console.log(event);
	//console.log('------ # jqXHR   # ------');
	//console.log(xhr);
	//console.log('------ # Setting # ------');
	//console.log(settings);
	//console.log('------ # thrownError #---');
	//console.log(thrownError);

	if(typeof settings.context !== "undefined"){
		switch (settings.context.context){
			case "form":
				switch(xhr.status){
					//Validation
					case 422:
						$.each(xhr.responseJSON.message, function(key, val){
							NOTIF.show({
								title   : "Form Error",
								message : val
							});
						});
					break;
					//Laravel
					case 400:
						NOTIF.show({
							title   : xhr.responseJSON.errors,
                    		message : xhr.responseJSON.message,
						});
					break;
					case 401:
						NOTIF.show({
							title   : xhr.responseJSON.title,
                    		message : xhr.responseJSON.message,
						});
					break;
				}
			break;
			case "rfid":
				NOTIF.show({
					title   : xhr.responseJSON.errors,
            		message : xhr.responseJSON.message,
				});
			break;
			case "table":
				NOTIF.show({
					title   : xhr.responseJSON.errors,
            		message : xhr.responseJSON.message,
				});
			break;
		}
	}
}

