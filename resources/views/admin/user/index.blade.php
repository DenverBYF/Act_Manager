@extends('adminlte::page')

@section('title', '人员名单')

@section('content')
    <div class="container">
        <div class="col-md-8 col-sm-8">
            <b>人员名单</b>
        </div>
        <div class="col-md-4 col-sm-4">
            <button class="btn-info btn-lg" data-toggle="modal" data-target="#adduser">通过文件导入成员</button>
            <a href="{{ route('download') }}"><button class="btn-success btn-lg">下载模版文件</button></a>
        </div>
        <div class="modal fade" id="adduser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">导入成员</h4>
                    </div>
                    <div class="modal-body">
                        <form id="add_user_form" class="form-horizontal" role="form" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group col-md-8">
                                <label for="file">人员名单(需与模版文件格式相同)</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="form-group">
                                <button class="form-control btn-primary" type="button" onclick="add_user()">导入</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        <div class="col-md-12 col-sm-12">
            <table id="user_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>邮箱</th>
                        <th>联系方式</th>
                        <th><input type="text" placeholder="通过学号或姓名搜索" onkeyup="search_user(this.value)"></th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @foreach($user as $eachUser)
                        <tr id="u{{$eachUser->id}}">
                            <th><a href="#">{{ $eachUser->name }}</a></th>
                            <th>{{ $eachUser->sex }}</th>
                            <th>{{ $eachUser->stuId }}</th>
                            <th>{{ $eachUser->email }}</th>
                            <th>{{ $eachUser->tel }}</th>
                            <th>
                                <form id="delete_user_form" class="form-horizontal" role="form" method="post" >
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button id="{{ $eachUser->id }}" class="btn-danger" type="button" onclick="delete_user(this.id)">删除该成员</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $user->links() }}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script type="text/javascript">
        function add_user() {
            var option = {
                success:function (data) {
                    $("#success").modal('show');
                },
                error:function (e) {
                    alert("添加失败");
                    console.log(e);
                }
            };
            $("#add_user_form").ajaxSubmit(option);
        }
        function delete_user(id) {
            var option = {
                url:"{{ route('users.index') }}"+"/"+id,
                success:function (data) {
                    $('#u'+id).remove();
                },
                error:function (e) {
                    alert("删除失败");
                    console.log(e);
                }
            };
            $("#delete_user_form").ajaxSubmit(option);
        }
        function search_user(value){
            $.ajax({
                url:"{{ route('search_user') }}"+"?data="+value,
                type:"GET",
                success:function (data) {
                    var table = $("#user_table");
                    $("#table_body").html("");
                    for (var i = 0; i<data.length; i++){
                        var newRow = '<tr><th><a href="#">'+data[i].name+'</a></th>\
                                <th>'+data[i].sex+'</th>\
                                <th>'+data[i].stuId+'</th>\
                                <th>'+data[i].email+'</th>\
                                <th>'+data[i].tel+'</th>\
                                <th>\
                                <form id="delete_user_form" class="form-horizontal" role="form" method="post" >\
                                {{ method_field('DELETE') }}\
                                {{ csrf_field() }}\
                                <button id="'+data[i].id+'" class="btn-danger" type="button" onclick="delete_user(this.id)">删除该成员</button>\
                                </form>\
                                </th>\
                                </tr>';
                        table.append(newRow);
                    }
                },
                error:function (e) {
                    console.log(e);
                }
            });
        }
    </script>
@endsection