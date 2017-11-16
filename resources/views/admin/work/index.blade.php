@extends('adminlte::page')

@section('title', '工作日程')

@section('css')
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection

@section('content_header')
    <h2>工作日程</h2>
@endsection

@section('content')
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="tabbable" id="tabs-602140">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#publicWork" data-toggle="tab">公开工作</a>
                        </li>
                        <li>
                            <a href="#managerWork" data-toggle="tab">你发布的工作</a>
                        </li>
                        <li>
                            <a href="#joinWork" data-toggle="tab">你参与的工作</a>
                        </li>
                        <li>
                            <a href="#userFinishWork" data-toggle="tab">你完成的工作</a>
                        </li>
                        <li>
                            <a href="#finishWork" data-toggle="tab">已完成的公开工作</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="publicWork">
                            @foreach($publicWork as $eachWork)
                                <div id="a{{ $eachWork->id }}" class="col-md-3 col-sm-3 panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#abody{{ $eachWork->id }}" data-toggle="collapse">
                                                {{ $eachWork->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="abody{{ $eachWork->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label for="content">
                                                工作内容
                                            </label>
                                            <p id="content">
                                                {{ $eachWork->content }}
                                            </p>
                                            <label for="manager">
                                                负责人
                                            </label>
                                            <p id="manager">
                                                {{ $eachWork->manager->name }}
                                            </p>
                                            <label for="time">
                                                时间
                                            </label>
                                            <p>
                                                {{ str_replace('T',' ',$eachWork->start_time) }} ~
                                                {{ str_replace('T',' ',$eachWork->end_time) }}
                                            </p>
                                            <label for="success">
                                                <button class="btn btn-success btn-sm" id="{{ $eachWork->id }}"
                                                        onclick="finish(this.id)">
                                                    完成
                                                </button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="managerWork">
                            @foreach($user->workManager->where('status',0) as $eachWork)
                                <div id="a{{ $eachWork->id }}" class="col-md-3 col-sm-3 panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#bbody{{ $eachWork->id }}" data-toggle="collapse">
                                                {{ $eachWork->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="bbody{{ $eachWork->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label for="content">
                                                工作内容
                                            </label>
                                            <p id="content">
                                                {{ $eachWork->content }}
                                            </p>
                                            <label for="manager">
                                                负责人
                                            </label>
                                            <p id="manager">
                                                {{ $eachWork->manager->name }}
                                            </p>
                                            <label for="time">
                                                时间
                                            </label>
                                            <p>
                                                {{ str_replace('T',' ',$eachWork->start_time) }} ~
                                                {{ str_replace('T',' ',$eachWork->end_time) }}
                                            </p>
                                            <label for="success">
                                                <button class="btn btn-success btn-sm" id="{{ $eachWork->id }}"
                                                        onclick="finish(this.id)">
                                                    完成
                                                </button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="joinWork">
                            @foreach($user->worksNotFinish as $eachWork)
                                <div id="a{{ $eachWork->id }}" class="col-md-3 col-sm-3 panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#cbody{{ $eachWork->id }}" data-toggle="collapse">
                                                {{ $eachWork->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="cbody{{ $eachWork->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label for="content">
                                                工作内容
                                            </label>
                                            <p id="content">
                                                {{ $eachWork->content }}
                                            </p>
                                            <label for="manager">
                                                负责人
                                            </label>
                                            <p id="manager">
                                                {{ $eachWork->manager->name }}
                                            </p>
                                            <label for="time">
                                                时间
                                            </label>
                                            <p>
                                                {{ str_replace('T',' ',$eachWork->start_time) }} ~
                                                {{ str_replace('T',' ',$eachWork->end_time) }}
                                            </p>
                                            <label for="success">
                                                <button class="btn btn-success btn-sm" id="{{ $eachWork->id }}"
                                                        onclick="finish(this.id)">
                                                    完成
                                                </button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="userFinishWork">
                            @foreach($user->worksFinish as $eachWork)
                                <div id="f{{ $eachWork->id }}" class="col-md-3 col-sm-3 panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#cbody{{ $eachWork->id }}" data-toggle="collapse">
                                                {{ $eachWork->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="cbody{{ $eachWork->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label for="content">
                                                工作内容
                                            </label>
                                            <p id="content">
                                                {{ $eachWork->content }}
                                            </p>
                                            <label for="manager">
                                                负责人
                                            </label>
                                            <p id="manager">
                                                {{ $eachWork->manager->name }}
                                            </p>
                                            <label for="time">
                                                时间
                                            </label>
                                            <p>
                                                {{ str_replace('T',' ',$eachWork->start_time) }} ~
                                                {{ str_replace('T',' ',$eachWork->end_time) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="finishWork">
                            @foreach($finishWork as $eachWork)
                                <div id="f{{ $eachWork->id }}" class="col-md-3 col-sm-3 panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#dbody{{ $eachWork->id }}" data-toggle="collapse">
                                                {{ $eachWork->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="dbody{{ $eachWork->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label for="content">
                                                工作内容
                                            </label>
                                            <p id="content">
                                                {{ $eachWork->content }}
                                            </p>
                                            <label for="manager">
                                                负责人
                                            </label>
                                            <p id="manager">
                                                {{ $eachWork->manager->name }}
                                            </p>
                                            <label for="time">
                                                时间
                                            </label>
                                            <p>
                                                {{ str_replace('T',' ',$eachWork->start_time) }} ~
                                                {{ str_replace('T',' ',$eachWork->end_time) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        function finish(id) {
            $.ajax({
                url:"{{ route('finish') }}",
                type:"GET",
                data:{'id':id},
                success:function (data) {
                    $('#a'+id).remove();
                },
                error:function (e) {
                    alert("失败");
                    console.log(e);
                }
            })
        }
    </script>
@endsection
