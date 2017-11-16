@extends('adminlte::page')

@section('title', '添加工作')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/fileinput.min.css') }}">

@section('content')
    <div class="container">
        <div class="col-md-10 col-sm-10">
            <form id="work_form" class="form-horizontal" role="form" method="post" action="{{ route('work.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group col-md-4 col-sm-4">
                    <label for="name">工作名称</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="col-md-1 col-sm-1"></div>
                <div class="form-group col-md-3 col-sm-3">
                    <label for="start_time">开始时间</label>
                    <input id="start_time" name="start_time" class="form-control" type="datetime-local">
                </div>
                <div class="col-md-1 col-sm-1"></div>
                <div class="form-group col-md-3 col-sm-3">
                    <label for="end_time">截止时间</label>
                    <input id="end_time" name="end_time" class="form-control" type="datetime-local">
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="desc">工作描述</label>
                    <textarea class="form-control" name="desc" id="desc" rows="10"></textarea>
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="group">人员分配</label>
                    @foreach($group as $each_group)
                        <div class="checkbox col-md-2 col-sm-2 form-control">
                            <label>
                                <input type="checkbox" name="groups[]" id="{{ $each_group->id }}" value="{{ $each_group->id }}">
                                {{ $each_group->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group col-md-9 col-sm-9">
                    <label for="uploadfile">工作附件(支持图片,pdf,xls,xlsx,doc,多文件打包(zip,rar)后上传)</label>
                    <input type="file" name="uploadfile" id="uploadfile" multiple class="file-loading form-control" />
                </div>
                <div class="col-md-1 col-sm-1"></div>
                <div class="form-group col-md-2 col-sm-2">
                    <label for="type">工作类型</label>
                    <div class="radio form-control" id="type">
                        <label>
                            <input type="radio" name="hidden" id="hidden" value="1">公开
                        </label>
                    </div>
                    <div class="radio form-control" id="type">
                        <label>
                            <input type="radio" name="hidden" id="hidden" value="0" checked>私有
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-2 col-sm-2">
                    <button class="btn btn-primary form-control" type="button" onclick="send_data()">创建</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/zh.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script type="text/javascript">
        $("#uploadfile").fileinput({
            language: 'zh', //设置语言
            uploadUrl: '', //上传的地址
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'pdf', 'xlsx', 'zip', 'rar'],//接收的文件后缀
            //uploadExtraData:{"id": 1, "fileName":'123.mp3'},
            uploadAsync: false, //默认异步上传
            showUpload: false, //是否显示上传按钮
            showRemove : true, //显示移除按钮
            showPreview : true, //是否显示预览
            showCaption: true, //是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: true,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            //maxImageWidth: 1000,//图片的最大宽度
            //maxImageHeight: 1000,//图片的最大高度
            maxFileSize: 4096,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 1, //表示允许同时上传的最大文件个数
            //enctype: 'multipart/form-data',
            validateInitialCount:true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            //msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
        });

        function send_data() {
            var option = {
                success:function (data) {
                    bootbox.alert("发布成功",function () {
                        window.location.reload();
                    });
                },
                error:function (e) {
                    bootbox.alert("发布失败");
                    console.log(e);
                }
            };
            $("#work_form").ajaxSubmit(option)
        }
    </script>
@endsection