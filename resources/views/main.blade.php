@extends('layouts.template')

@push('css')
{{ Html::style('assets/css/zabuto_calendar.css') }}
{{ Html::style('assets/js/gritter/css/jquery.gritter.css') }}
{{ Html::style('assets/lineicons/style.css') }}
@endpush

@push('js')
{{ Html::script('assets/js/zabuto_calendar.js') }}
{{ Html::script('pages/home.js') }}
@endpush

@section('title', config('app.description'))

@section('content')
        <!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9 main-chart">

                <div class="row mtbox">
                    <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                        <div class="box1">
                            <span class="li_heart"></span>
                            <h3>933</h3>
                        </div>
                        <p>933 People liked your page the last 24hs. Whoohoo!</p>
                    </div>

                    <div class="col-md-2 col-sm-2 box0">
                        <div class="box1">
                            <span class="li_cloud"></span>
                            <h3>+48</h3>
                        </div>
                        <p>48 New files were added in your cloud storage.</p>
                    </div>

                    <div class="col-md-2 col-sm-2 box0">
                        <div class="box1">
                            <span class="li_stack"></span>
                            <h3>23</h3>
                        </div>
                        <p>You have 23 unread messages in your inbox.</p>
                    </div>

                    <div class="col-md-2 col-sm-2 box0">
                        <div class="box1">
                            <span class="li_news"></span>
                            <h3>+10</h3>
                        </div>
                        <p>More than 10 news were added in your reader.</p>
                    </div>

                    <div class="col-md-2 col-sm-2 box0">
                        <div class="box1">
                            <span class="li_data"></span>
                            <h3>OK!</h3>
                        </div>
                        <p>Your server is working perfectly. Relax & enjoy.</p>
                    </div>

                </div><!-- /row mt -->

                <div class="row mt">
                    <!--CUSTOM CHART START -->
                    <div class="border-head">
                        <h3>VISITS</h3>
                    </div>
                    <div class="custom-bar-chart">
                        <ul class="y-axis">
                            <li><span>10.000</span></li>
                            <li><span>8.000</span></li>
                            <li><span>6.000</span></li>
                            <li><span>4.000</span></li>
                            <li><span>2.000</span></li>
                            <li><span>0</span></li>
                        </ul>
                        <div class="bar">
                            <div class="title">JAN</div>
                            <div class="value tooltips" data-original-title="8.500" data-toggle="tooltip" data-placement="top">85%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">FEB</div>
                            <div class="value tooltips" data-original-title="5.000" data-toggle="tooltip" data-placement="top">50%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">MAR</div>
                            <div class="value tooltips" data-original-title="6.000" data-toggle="tooltip" data-placement="top">60%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">APR</div>
                            <div class="value tooltips" data-original-title="4.500" data-toggle="tooltip" data-placement="top">45%</div>
                        </div>
                        <div class="bar">
                            <div class="title">MAY</div>
                            <div class="value tooltips" data-original-title="3.200" data-toggle="tooltip" data-placement="top">32%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">JUN</div>
                            <div class="value tooltips" data-original-title="6.200" data-toggle="tooltip" data-placement="top">62%</div>
                        </div>
                        <div class="bar">
                            <div class="title">JUL</div>
                            <div class="value tooltips" data-original-title="7.500" data-toggle="tooltip" data-placement="top">75%</div>
                        </div>
                    </div>
                    <!--custom chart end-->
                </div><!-- /row -->

            </div><!-- /col-lg-9 END SECTION MIDDLE -->

            @include('fixed.notification')

        </div><! --/row -->
    </section>
</section>
<!-- /MAIN CONTENT -->
@endsection