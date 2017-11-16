@extends('adminlte::page')

@section('title', '分组编辑')

@section('content_header')
    <h2>{{ $group->name }}</h2>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h4>人员名单</h4>
            </div>
            <div class="col-md-6 col-sm-6">
                <button class="btn-info btn-lg" data-toggle="modal" data-target="#add_user">从成员列表导入</button>
                <button class="btn-success btn-lg" data-toggle="modal" data-target="#file_add">从文件导入</button>
            </div>
            <div class="modal fade" id="file_add" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">导入成员</h4>
                        </div>
                        <div class="modal-body">
                            <form id="add_user_by_file" class="form-horizontal" role="form" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group col-md-8">
                                    <label for="file">人员名单(需与模版文件格式相同)</label>
                                    <input class="form-control" type="file" name="file" id="file">
                                </div>
                                <div class="form-group">
                                    <button id="{{ $group->id }}" class="form-control btn-primary" type="button" onclick="add_user(this.id,'add_user_by_file')">导入</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" aria-hidden="true" id="add_user">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p>成员导入(在现有成员内选择成员加入该分组)</p>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" id="add_user_form" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    @foreach($member as $eachMember)
                                        <div class="checkbox form-control">
                                            <label>
                                                <input type="checkbox" name="user_id[]" id="{{ $eachMember->id }}" value="{{ $eachMember->id }}">
                                                {{ $eachMember->name }}&nbsp;&nbsp;&nbsp;{{ $eachMember->stuId }}&nbsp;&nbsp;&nbsp;{{$eachMember->email}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <button type="button" id="{{ $group->id }}" onclick="add_user(this.id,'add_user_form')"  class="btn-primary form-control">导入</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>邮箱</th>
                        <th>联系方式</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user as $eachUser)
                        <tr id="u{{ $eachUser->id }}">
                            <th><a href="#">{{ $eachUser->name }}</a></th>
                            <th>{{ $eachUser->sex }}</th>
                            <th>{{ $eachUser->stuId }}</th>
                            <th>{{ $eachUser->email }}</th>
                            <th>{{ $eachUser->tel }}</th>
                            <th>
                               <button class="btn-danger" type="button" id="{{ $eachUser->id }}" onclick="delete_user(this.id)">移除该成员</button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $user->links() }}
            </div>
            <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">导入成功</div>
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
        function add_user(id,name) {
            var option = {
                url:"{{ route('groups.index') }}"+"/"+id,
                success:function (data) {
                    $("#success").modal('show');
                },
                error:function (e) {
                    alert(e);
                    console.log(e);
                }
            };
            $('#'+name+'').ajaxSubmit(option);
        }
        function delete_user(id) {
            $.ajax({
                url:"{{ route('deleteUserFromGroup') }}"+"?id="+id+"&name="+"{{ $group->name }}",
                type:"GET",
                success:function (data) {
                    $('#u'+id).remove();
                },
                error:function (e) {
                    alert("导入失败");
                    console.log(e);
                }
            })
        }
    </script>
@endsection