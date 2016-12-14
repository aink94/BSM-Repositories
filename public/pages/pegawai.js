var form = '' +
    '<form class="form-horizontal">'+
    '<div class="modal-body">'+
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Nama</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="nama" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">username</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="username" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Password</label>'+
    '<div class="col-sm-9">' +
    '<input type="password" name="password" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Status</label>'+
    '<div class="col-sm-9">' +
    '<select name="status" class="form-control">'+
    '<option value="">Pilih Status</option>'+
    '<option value="ADMIN">ADMIN</option>'+
    '<option value="PEGAWAI">PEGAWAI</option>'+
    '<option value="MANAGER">MANAGER</option>'+
    '</select>'+
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
    "autoWidth"   : false,
    "select"      : {
        style: 'single'
    },
    "ajax"        : {
    	"context" :{
    		"context" : "table"
    	},
        "url"     : "/pegawai",
        "dataSrc" : "data.data"
    },
    "columns"     : [
        {"data": "id"},
        {"data": "nama"},
        {"data": "username"},
        {"data": "action"},
    ]
});



$(function(){
	
	$("table#table tbody").on('click', 'tr td button#btn-ubah', function(event){
 		event.preventDefault();
 		var id = $(this).data('id');
		$.getJSON('pegawai/data/'+id)
		.done(function(json){
			console.log(json);
			$('body').append(modal);
			if($('form').length == 0) {
				$('.modal-content').append(form);
			}
			$("#modal").find("form.form-horizontal input[name=nama]").after(function(){
				if($('input[name="id"]').length == 0)
					return '<input type="hidden" name="id">';
			});
			//tambah help-block di password
			$("form.form-horizontal").find("input[name=password]").after(function(){
				if($('span.help-block').length == 0)
					return '<span class="help-block">Kosongkan apabila tidak diganti</span>';
			});

			$("input[name=id]").val(json.data.data.id);
			$("input[name=nama]").val(json.data.data.nama);
			$("input[name=username]").val(json.data.data.username);
			//$("input[name=password]").val(rowData[0].password);
			$("select[name=status]").val(json.data.data.status);

			$('.modal-title').text("Ubah Pegawai");
			$('#modal').modal({keyboard: false, backdrop: 'static'});

			$(".modal").on("click", "#btnSimpan", function(event){
				$.ajax({
					context : {
						"event"   : event,
						"context" : 'form'
					},
					global   : true,
					type     : 'PUT',
					url      : window.location+"/ubah/"+id,
					dataType : "json",
					data     : {
						"nama":$("input[name=nama]").val(),
						"username":$("input[name=username]").val(),
						"password":$("input[name=password]").val(),
						"status":$("select[name=status]").val()
					}
				}).done(function(){
					table.ajax.reload();
				});
			});

			$("#modal").on('hidden.bs.modal', function(e){
				$(this).remove();
			});
		});
 	});

	$("table#table tbody").on('click', 'tr td button#btn-hapus', function(event){
 		event.preventDefault();
 		var id = $(this).data('id');

		$('body').append(modal);
		if($('form').length == 0) {
			$('.modal-content').append(formhapus);
		}

		//$("#modal").find("form.form-horizontal .modal-footer").after(function(){
 		//	if($('input[name="id"]').length == 0)
 		//		return '<input type="hidden" name="id">';
 		//});

		$('.modal-title').text("Apakah yakin Akan dihapus ?");
		$('.modal-dialog').addClass('modal-sm');
		$('#modal').modal({keyboard: false, backdrop: 'static'});

		//$("input[name=id]").val(id);
 		//AJAX
 		$(".modal").on("click", "#btnSimpan", function(event){
			$.ajax({
				context : {
					"context": "form"
				},
				url  : window.location+"/hapus/"+id,
				type : "POST",
				dataType : "json"
			})
			.done(function(){
				table.ajax.reload();
			});
 		});

 		$("#modal").on('hidden.bs.modal', function(e){
	        $(this).remove();
	    });
 		
 	});

	$('#tambah').on('click', function(event){
		console.log(event);
 		$('body').append(modal);
 		if($('form').length == 0) {
	        $('.modal-content').append(form);
	    }
 		$('.modal-title').text("Tambah Pegawai");
 		$('#modal').modal({keyboard: false, backdrop: 'static'});

 		//AJAX
 		$(".modal").on("click", "#btnSimpan", function(event){
 			$.ajax({
 				context : {
					"event"   : event,
					"context" : 'form'
				},
				async   : true,
 				type    : 'POST',
	            url     : window.location+"/tambah",
	            dataType: 'json',
	            data: {
					"nama"     : $("input[name=nama]").val(),
					"username" : $("input[name=username]").val(),
					"password" : $("input[name=password]").val(),
					"status"   : $("select[name=status]").val()
	            }
 			})
 			.done(function(){
 				table.ajax.reload();
 			});
 		});

		$("#modal").on('hidden.bs.modal', function(e){
			$('.modal').remove();
			$(this).data('modal', null);
		});
 	});
});