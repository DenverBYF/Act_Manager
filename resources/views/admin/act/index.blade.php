@extends('adminlte::page')

@section('title', '活动管理')

@section('content_header')
    <h2>活动管理</h2>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>主题</th>
                        <th>时间</th>
                        <th>地点</th>
                        <th>到会情况</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($act as $eachAct)
                        <tr>
                            <th>{{ $eachAct->name }}</th>
                            <th>{{ $eachAct->time }}</th>
                            <th>{{ $eachAct->address }}</th>
                            <th>{{ $eachAct->users->count() }}&nbsp; / &nbsp;{{ $eachAct->joinUser->count() }}</th>
                            <th>
                                <a href="{{ route('act.edit',['id'=>$eachAct->id]) }}">
                                    <button id="{{ $eachAct->id }}" class="btn-primary">活动记录</button>
                                </a>
                            </th>
                            <th>
                                <button class="btn-success" data-toggle="modal" data-target="#sign_user{{ $eachAct->id }}" type="button">会议签到</button>
                            </th>
                            <th>
                                <form class="form-horizontal" role="form" id="delete_form" method="post" >
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn-danger" id="{{ $eachAct->id }}" onclick="delete_act(this.id)">删除该活动</button>
                                </form>
                            </th>
                        </tr>
                        <div class="modal fade" id="sign_user{{ $eachAct->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p>人员签到</p>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="form_{{ $eachAct->id }}" role="form" id="add_user_form" method="post" action="{{ route('sign') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $eachAct->id }}" name="act">
                                            <div class="form-group">
                                                @foreach($eachAct->notJoinUser as $eachMember)
                                                    <div class="checkbox form-control">
                                                        <label>
                                                            <input type="checkbox" name="user_id[]" id="{{ $eachMember->id }}" value="{{ $eachMember->id }}">
                                                            {{ $eachMember->name }}&nbsp;&nbsp;&nbsp;{{ $eachMember->stuId }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <button id="{{ $eachAct->id }}" type="button" onclick="sign(this.id)" class="btn-primary form-control">签到</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
                {{ $act->links() }}
            </table>
            <div class="modal fade" id="delete_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">删除成功</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">签到成功</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">关闭</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script type="text/javascript">
        function delete_act(id) {
            var option = {
                url:"{{ route('act.index') }}"+"/"+id,
                success:function (data) {
                    $("#delete_success").modal('show');
                },
                error:function (e) {
                    alert("删除失败");
                    console.log(e);
                }
            };
            $("#delete_form").ajaxSubmit(option);
        }
        function sign(id) {
            var option = {
                success:function (data) {
                    $("#success").modal('show');
                },
                error:function (e) {
                    alert("签到失败");
                    console.log(e);
                }
            };
            $('#form_'+id).ajaxSubmit(option);
        }
    </script>
@endsection