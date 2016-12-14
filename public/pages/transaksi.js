var form = '' +
    '<form class="form-horizontal">'+
    '<div class="modal-body">'+
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">UID</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="uid" class="form-control" readonly>'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">NIS</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="nis" class="form-control" readonly>'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Nama</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="nama" class="form-control" readonly>'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Jumlah Uang</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="jumlah" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
    '<div class="modal-footer">'+
    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
    '<button type="button" class="btn btn-default" id="btnSimpan">Simpan</button>'+
    '</div>'+
    '</form>';
var formhapus = '' +
    '<form class="form-horizontal">'+
    '<div class="modal-footer">'+
    '<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>'+
    '<button type="button" class="btn btn-default" id="btnSimpan">Ya</button>'+
    '</div>'+
    '</form>';
var table = $("#table").DataTable({
	"processing"  : true,
    //"serverSide": true,
    "paging"      : true,
    "lengthChange": false,
    "searching"   : true,
    "ordering"    : false,
    "info"        : false,
    "autoWidth": false,
    "select"      : {
        style: 'single'
    },
    "ajax"        : {
    	"context" : {
    		"context" : "table"
    	},
        "url"     : "/transaksi",
        "dataSrc" : "data.data"
    },
    "columns"     : [
        {"data": "nasabah"},
        {"data": "tanggal"},
        {"data": "jumlah"},
        {"data": "jenis_transaksi"},
    ]
});

function buttonDisabled(){
	$('button#simpan').attr("disabled", true);
	$('button#tarik').attr("disabled", true);
}
function buttonEnabled(){
	$('button#simpan').prop('disabled', false);
	$('button#tarik').prop('disabled', false);
}

$(function(){
	var arduino = io(window.location.hostname+':9898');
	arduino.on("connect", function(){
		buttonEnabled();
	});
	arduino.on('disconnect', function (socket) {
		buttonDisabled();
	});
	$('button#simpan').on('click', function(event){
		$('body').append(modal);
		if($('form').length == 0) {
			$('.modal-content').append(rfidform);
		}
		$('.modal-title').text("Simpan Uang");
		$('#modal').modal({keyboard: false, backdrop: 'static'});

		arduino.emit('simpan', {menu:'a', id:event.target}); //----------------------> kirim data to arduino
		buttonDisabled();

		$("#modal").on('hidden.bs.modal', function(e){
			$(this).remove();
		});
	});

	arduino.on("simpan", function(data){
		//console.log(data);
		if(data.indexOf('#MenuRead#') >= 0 || data.indexOf("#PilihMenu#") >= 0){
			//console.log("Data To Laravel ----------> "+data);
		}else{
			var objData = JSON.parse(data.substring(0, data.length - 1));//---------{ Membuang karackter terakhir (#) dan membuat convert string to json }
			if ('error' in objData){
				if(objData.error == "Request Time Out")
					buttonEnabled();
				$('#modal').modal("hide");
				NOTIF.show({
					type    : "error",
					title   : objData.error,
					message : objData.error
				});
			}else{
				var params = $.param({
					"uid":objData.uid,
					"nis":objData.nis
				});
				//cek DataBase
				$.getJSON(window.location+'/cekuidnis?'+params)
					.done(function(data){
						console.log(data.message);
						$('form').remove();
						if($('form').length == 0) {
							$('.modal-content').append(form);
						}
						$("input[name=uid]").val(data.data.uid);
						$("input[name=nis]").val(data.data.nis);
						$("input[name=nama]").val(data.data.nama);
						$('form').prepend('<input type="hidden" name="nasabah_id" value="'+data.data.id+'"/>');
						$(".modal").on("click", "button#btnSimpan", function(){
							var params = $.param({
								jumlah     : $("input[name=jumlah]").val(),
								nasabah_id : $("input[name=nasabah_id]").val()
							});
							$.ajax({
								context : {
									context: "form"
								},
								type : "POST",
								url  : window.location+"/simpan",
								dataType : "json",
								data : params
							}).done(function(){
								table.ajax.reload();
								buttonEnabled();
							});
						});

					})
					.fail(function(event, xhr, setting){
						NOTIF.show({
							type    : "error",
							title   : event.responseJSON.message,
							message : event.responseJSON.message
						});
						$('#modal').modal("hide");
						buttonEnabled();
					});

			}
		}
	});

	$('button#tarik').on('click', function(event){
		$('body').append(modal);
		if($('form').length == 0) {
			$('.modal-content').append(rfidform);
		}
		$('.modal-title').text("Tarik Uang");
		$('#modal').modal({keyboard: false, backdrop: 'static'});

		arduino.emit('tarik', {menu:'a', id:event.target}); //----------------------> kirim data to arduino
		buttonDisabled();

		$("#modal").on('hidden.bs.modal', function(e){
			$(this).remove();
		});
 	});

	arduino.on("tarik", function(data){
		if(data.indexOf('#MenuRead#') >= 0 || data.indexOf("#PilihMenu#") >= 0){
			//console.log("Data To Laravel ----------> "+data);
		}else{
			var objData = JSON.parse(data.substring(0, data.length - 1));//---------{ Membuang karackter terakhir (#) dan membuat convert string to json }
			if ('error' in objData){
				if(objData.error == "Request Time Out")
					buttonEnabled();
				$('#modal').modal("hide");
				NOTIF.show({
					type    : "error",
					title   : objData.error,
					message : objData.error
				});
			}else{
				var params = $.param({
					"uid":objData.uid,
					"nis":objData.nis
				});
				//cek DataBase
				$.getJSON(window.location+'/cekuidnis?'+params)
					.done(function(data){
						$('form').remove();
						if($('form').length == 0) {
							$('.modal-content').append(form);
						}
						$("input[name=uid]").val(data.data.uid);
						$("input[name=nis]").val(data.data.nis);
						$("input[name=nama]").val(data.data.nama);
						$('form').prepend('<input type="hidden" name="nasabah_id" value="'+data.data.id+'"/>');

						$(".modal").on("click", "button#btnSimpan", function(){
							var params = $.param({
								jumlah     : $("input[name=jumlah]").val(),
								nasabah_id : $("input[name=nasabah_id]").val()
							});
							$.ajax({
								context : {
									context: "form"
								},
								type : "POST",
								url  : window.location+"/tarik",
								dataType : "json",
								data : params
							}).done(function(){
								table.ajax.reload();
								buttonEnabled();
							}).fail(function(event){
								NOTIF.show({
									type    : "error",
									title   : event.responseJSON.message,
									message : event.responseJSON.message
								});
								$('#modal').modal("hide");
								buttonEnabled();
							});
						});

					}).fail(function(event){
						NOTIF.show({
							type    : "error",
							title   : event.responseJSON.message,
							message : event.responseJSON.message
						});
						$('#modal').modal("hide");
						buttonEnabled();
					});
			}
		}
	});



	$('button#belanja').on('click', function(event){
		$('body').append(modal);
		if($('form').length == 0) {
			$('.modal-content').append(form);
		}
		$('.modal-title').text("Belanja");
		$('#modal').modal({keyboard: false, backdrop: 'static'});

		$(".modal").on("click", "button#btnSimpan", function(){
			var params = $.param({
				jumlah: $("input[name=jumlah]").val()
			});
			$.ajax({
				context : {
					context: "form"
				},
				type     : "POST",
				url      : window.location+"/belanja",
				dataType : "json",
				data     : params
			}).done(function(){
				table.ajax.reload();
			});
		});

        $("#modal").on('hidden.bs.modal', function(e){
            $(this).remove();
        });
 	});

	$(document.body).on('hidden.bs.modal', '#modal', function () {
		this.remove();
	});

});
