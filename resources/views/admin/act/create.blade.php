@extends('adminlte::page')

@section('title', '活动发布')

@section('content_header')
    <h3>活动发布</h3>
@endsection

@section('content')
    <div class="container">
        <div id="row">
            <form class="form-horizontal" role="form" id="act_from" method="post" action="{{ route('act.store') }}">
                {{ csrf_field() }}
                <div class="col-md-4 col-sm-4">
                    <label for="name">活动名称</label>
                    <input id="name" name="name" class="form-control" type="text">
                </div>
                <div class="col-md-4 col-sm-4">
                    <label for="time">时间</label>
                    <input id="time" name="time" class="form-control" type="datetime-local">
                </div>
                <div class="col-md-4 col-sm-4">
                    <label for="address">地点</label>
                    <input id="address" name="address" class="form-control" type="text">
                </div>
                <div class="col-md-8 col-sm-8">
                    <label for="desc">活动内容描述</label>
                    <textarea id="desc" name="desc" class="form-control" rows="10"></textarea>
                </div>
                <div class="col-md-4 col-sm-4">
                    <label for="group">所需参与人员(选择相应分组)</label>
                    @foreach($group as $each_group)
                        <div class="checkbox col-md-2 col-sm-2 form-control">
                            <label>
                                <input type="checkbox" name="groups[]" id="{{ $each_group->id }}" value="{{ $each_group->id }}">
                                {{ $each_group->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-8 col-sm-8">
                    <label for="bz">备注(可选)</label>
                    <textarea id="bz" name="bz" class="form-control" rows="5"></textarea>
                </div>
                <div class="col-md-12 col-sm-12">
                    <button class="btn-primary btn-lg" type="button" onclick="send_act()">发布</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript">
        function send_act() {
            var option = {
                success:function (data) {
                    bootbox.alert("发布成功",function () {
                        window.location.reload();
                    })
                },
                error:function (e) {
                    bootbox.alert("发布失败",function () {
                        console.log(e);
                    })
                }
            };
            $("#act_from").ajaxSubmit(option);
        }
    </script>
@endsection