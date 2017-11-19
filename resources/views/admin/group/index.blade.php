@extends('adminlte::page')

@section('title', '组别管理')

@section('content')
    <div class="container">
        <div class="col-md-8 col-sm-8">
            <h2>组别管理</h2>
        </div>
        <div class="col-md-4 col-sm-4">
            <button class="btn-info btn-lg" data-toggle="modal" data-target="#add_group">创建新的分组</button>
        </div>
        <div class="modal fade" id="add_group" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>创建新的分组</h3>
                    </div>
                    <div class="modal-body">
                        <form id="add_group_form" class="form-horizontal" role="form" action="{{ route('groups.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" id="name" placeholder="分组名称">
                            </div>
                            <label for="permission">权限授予(不设置即为普通用户权限)</label>
                            <div class="form-group" id="permission">
                                <div class="checkbox form-control">
                                    <label><input type="checkbox" name="create_user" value="create_user">人员管理</label>
                                </div>
                                <div class="checkbox form-control">
                                    <label><input type="checkbox" name="create_act" value="create_act">活动发布</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn-primary form-control" type="button" onclick="add_group()">提交</button>
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
                        <th>序号</th>
                        <th>名称</th>
                        <th>人数</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $eachGroup)
                        <tr id="g{{ $eachGroup->id }}">
                            <th>{{ $loop->index + 1 }}</th>
                            <th>{{ $eachGroup->name }}</th>
                            <th>{{ \App\User::role($eachGroup->name)->count() }}</th>
                            <th>
                                <a href="{{ route('groups.edit',['id'=>$eachGroup->name]) }}">
                                    <button class="btn-info">编辑该分组</button>
                                </a>
                            </th>
                            <th>
                                @manager($eachGroup->id)
                                <form id="delete_group_form" class="form-horizontal" role="form" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button id="{{ $eachGroup->id }}" class="btn-danger" type="button" onclick="delete_group(this.id)">删除该分组</button>
                                </form>
                                @endmanager
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">创建成功</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">关闭</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script type="text/javascript">
        function add_group() {
            var option = {
                success:function (data) {
                    $("#success").modal('show');
                },
                error:function (e) {
                    alert("添加失败");
                    console.log(e);
                }
            };
            $("#add_group_form").ajaxSubmit(option);
        }
        function delete_group(id) {
            var option = {
                url : "{{ route('groups.index') }}"+"/"+id,
                success:function (data) {
                    $('#g'+id).remove();
                },
                error:function (e) {
                    alert("删除失败");
                    console.log(e);
                }
            };
            $("#delete_group_form").ajaxSubmit(option);
        }
    </script>
@endsection