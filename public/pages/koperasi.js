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
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">api token</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="token" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">key</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="key" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
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
	//"processing"  : true,
    //"serverSide"  : true,
    "paging"      : true,
    "lengthChange": false,
    "searching"   : false,
    "ordering"    : false,
    "info"        : false,
    "autoWidth"   : false,
    "select"      : {
        style: 'single'
    },
    "ajax"        : {
        "context" : {
            "context" : "table"
        },
        "url"     : "/koperasi",
        "dataSrc" : "data.data"
    },
    "columns"     : [
        {"data": "id"},
        {"data": "nama"},
        {"data": "action"}
    ]
});

$(function(){
	$("table#table tbody").on('click', 'tr td button#btn-ubah', function(event){
        event.preventDefault();
        var id = $(this).data('id');
        $.getJSON('koperasi/data/'+id)
            .done(function(json){
                $('body').append(modal);
                if($('form').length == 0) {
                    $('.modal-content').append(form);
                }

                //tambah help-block di api
                $("form.form-horizontal").find("input[name=token]").after(function(){
                    if($('span.token').length == 0)
                        return '<span class="help-block token">Kosongkan apabila tidak diganti</span>';
                });
                //tambah help-block di api
                $("form.form-horizontal").find("input[name=key]").after(function(){
                    if($('span.key').length == 0)
                        return '<span class="help-block key">Kosongkan apabila tidak diganti</span>';
                });

                $('.modal-title').text("Ubah Pegawai");
                $('#modal').modal({keyboard: false, backdrop: 'static'});

                $("input[name=nama]").val(json.data.data.nama);


                //AJAX
                $(".modal").on("click", "#btnSimpan", function(event){
                    var xhr = $.ajax({
                        context : {
                            "event"   : event,
                            "context" : 'form'
                        },
                        global  : true,
                        type    : 'PUT',
                        url     : window.location+"/ubah/"+id,
                        dataType: 'json',
                        data: {
                            'nama'  : $("input[name=nama]").val(),
                            'token' : $("input[name=token]").val(),
                            'key'   : $("input[name=key]").val()
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

        $('.modal-title').text("Apakah yakin Akan dihapus ?");
        $('.modal-dialog').addClass('modal-sm');
        $('#modal').modal({keyboard: false, backdrop: 'static'});

        //AJAX
        $(".modal").on("click", "#btnSimpan", function(event){
            $.ajax({
                context : {
                    "context": "form"
                },
                global : true,
                url    : window.location+"/hapus/"+id,
                type   : "POST",
                dataType : "json"
            }).done(function(){
                table.ajax.reload();
            });
        });

        $("#modal").on('hidden.bs.modal', function(e){
            $(this).remove();
        });
        
    });

	$('#tambah').on('click', function(){
 		$('body').append(modal);
 		if($('form').length == 0) {
	        $('.modal-content').append(form);
	    }
 		$('.modal-title').text("Tambah Koperasi");
 		$('#modal').modal({keyboard: false, backdrop: 'static'});

 		//AJAX
 		$(".modal").on("click", "#btnSimpan", function(event){
 			$.ajax({
                context : {
                    "event"   : event,
                    "context" : 'form'
                },
 				type    : 'POST',
	            url     : window.location+"/tambah",
	            dataType: 'json',
                async   : false,
	            data: {
					'nama'    : $("input[name=nama]").val(),
					'token'   : $("input[name=token]").val(),
					'key'     : $("input[name=key]").val(),	                
	            }
 			}).done(function(){
                table.ajax.reload();
            });
 		});

 		$("#modal").on('hidden.bs.modal', function(e){
            $('.modal').remove();
        });
 	});
});

