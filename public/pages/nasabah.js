var rfidform = ''+
	'<form>'+
	'<div class="modal-body icon-rfid">'+
	'<center>'+
	'<img src="assets/img/scan-rfid.gif">'+
	'</center>'+
	'</div>'+
	'</form>';
var form = '' +
    '<form class="form-horizontal">'+
    '<div class="modal-body">'+
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">UID</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="uid" class="form-control" >'+
    '</div>'+
    '</div>'+
    //end-form-group
    //form-group
    '<div class="form-group">'+
    '<label class="col-sm-3 control-label">Nis</label>'+
    '<div class="col-sm-9">' +
    '<input type="text" name="nis" class="form-control">'+
    '</div>'+
    '</div>'+
    //end-form-group
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
    '<label class="col-sm-3 control-label">Status Kartu</label>'+
    '<div class="col-sm-9">' +
    '<select name="status_kartu" class="form-control">'+
	'<option value="">Pilih Status Kartu</option>'+
	'<option value="GOLD">GOLD</option>'+
	'<option value="SILVER">SILVER</option>'+    
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
var detailtransaksi = '' +
    '<form>' +
    '<div class="modal-body" id="body-detail"></div>' +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
    '</div>' +
    '</form>';
var table = $("#table").DataTable({
	"processing": true,
    //"serverSide"  : true,
    "paging"      : true,
    "lengthChange": false,
    "searching"   : true,
    "ordering"    : false,
    "info"        : false,
    "autoWidth"   : false,
    "select"      : {
        style: 'single'
    },
    "ajax"        :{
    	"context" :{
    		"context" : "table"
    	},
        "url"     : "/nasabah",
        "dataSrc" : "data.data"
    },
    "columns"     : [
        {"data": "uid"},
        {"data": "nis"},
        {"data": "nama"},
        {"data": "status_kartu"},
        {"data": "action"},
    ]
});

$(function(){
    $("button#btn-tambah").on("click", function(){
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
                    'uid'          : $("input[name=uid]").val(),
                    'nis'          : $("input[name=nis]").val(),
                    'nama'         : $("input[name=nama]").val(),
                    'status_kartu' : $("select[name=status_kartu]").val(),
                }
            }).done(function(){
                table.ajax.reload();
            });
        });

        $("#modal").on('hidden.bs.modal', function(e){
            $('.modal').remove();
        });
    });

    $("table#table tbody").on('click', 'tr td button#btn-ubah', function(event){
        var id = $(this).data('id');
        $.getJSON('nasabah/data/'+id)
            .done(function(json){
                $('body').append(modal);
                if($('form').length == 0) {
                    $('.modal-content').append(form);
                }
                $('input[name=uid]').prop('readonly', true);
                $('input[name=nis]').prop('readonly', true);
                $('.modal-title').text("Ubah Nasabah");
                $('#modal').modal({keyboard: false, backdrop: 'static'});

                $("input[name=uid]").val(json.data.data.uid);
                $("input[name=nis]").val(json.data.data.nis);
                $("input[name=nama]").val(json.data.data.nama);
                $("select[name=status_kartu]").val(json.data.data.status_kartu);

                $(".modal").on("click", "#btnSimpan", function(){
                    $.ajax({
                        context : {
                            "event"   : event,
                            "context" : 'form'
                        },
                        global  : true,
                        type    : 'PUT',
                        url     : window.location+"/ubah/"+id,
                        dataType: 'json',
                        data: {
                            'uid'          : $("input[name=uid]").val(),
                            'nis'          : $("input[name=nis]").val(),
                            'nama'         : $("input[name=nama]").val(),
                            'status_kartu' : $("select[name=status_kartu]").val(),
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

    $("table#table tbody").on("click", "tr td button#btn-hapus", function(event){
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

    $("table#table tbody").on('click', 'tr td button#btn-lihat', function(event){
        var id = $(this).data('id');
        $.getJSON('nasabah/lihat/'+id)
            .done(function(json){
                $('body').append(modal);
                if($('form').length == 0) {
                    $('.modal-content').append(detailtransaksi);
                }
                //Informasi Nasabah
                var info = '' +
                    '<div class="col-sm-12">' +
                    '<h5>NIS : '+json.nasabah.data.nis+'</h5>' +
                    '<h5>Nama : '+json.nasabah.data.nama+'</h5>' +
                    '<h5>Saldo Akhir : '+json.saldo_akhir+'</h5>' +
                    '</div>';
                //table-detail
                var tr = '';
                $.each(json.transaksi.data, function(key, val){
                    tr += '<tr>' +
                        '<td>'+val.tanggal+'</td><td>'+val.jumlah+'</td><td>'+val.saldo+'</td><td>'+val.jenis_transaksi+'</td>' +
                        '</tr>';
                });
                var tabledetail = '<table class="table table-bordered" id="table-detail-transaksi">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Tanggal</th><th>Jumlah</th><th>Saldo</th><th>Jenis Transaksi</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                        tr
                    '</tbody>' +
                    '</table>';

                $('#body-detail').prepend(tabledetail);
                $('#body-detail').prepend(info);
                $('.modal-title').text("Detail Transaksi");
                $('#modal').modal({keyboard: false, backdrop: 'static'});

                $("#modal").on('hidden.bs.modal', function(e){
                    $(this).remove();
                });
            });
    });
});