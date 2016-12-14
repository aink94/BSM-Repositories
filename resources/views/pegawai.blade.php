@extends('layouts.template')

@push('css')
{{ Html::style('assets/js/gritter/css/jquery.gritter.css') }}
{{ Html::style('assets/bower_components/datatables.net-dt/css/jquery.dataTables.css') }}
@endpush

@push('js')
{{ Html::script('assets/bower_components/datatables.net/js/jquery.dataTables.js') }}
{{ Html::script('pages/pegawai.js') }}
@endpush

@section('title', config('app.description'))

@section('content')
        <!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9">

                <h3> <i class="fa fa-users"></i> Daftar Pegawai</h3>

                <div class="row mtbox" style="margin-bottom: 10px">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right">
                            <button class="btn btn-default" id="tambah">Tambah</button>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px">

                    <div class="col-sm-12">
                        <div class="content-panel">
                            <section id="unseen">
                                <table class="table table-bordered table-condensed" id="table">
                                    <thead>
                                    <tr>
                                        <th width="40px">#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                </table>
                            </section>
                        </div>
                    </div>


                </div><!-- /row mt -->


            </div><!-- /col-lg-9 END SECTION MIDDLE -->
        @include('fixed.notification')
    </section>
</section>
<!-- /MAIN CONTENT -->
@endsection