@extends('adminlte::page')

@section('title', '工作日程')

@section('css')
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
@endsection

@section('content_header')
    <h2>工作日程</h2>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-3 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                                href="#collapseTwo">
                            点击我进行展开，再次点击我进行折叠。第 2 部分
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
