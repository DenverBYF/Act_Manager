@extends('adminlte::page')

@section('title', '修改密码')

@section('css')
    <link rel="stylesheet" href="{{ asset('btv/css/bootstrapValidator.min.css') }}">
@endsection

@section('content_header')
    <h3>{{ $user->name }}</h3>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3"></div>
            <div class="col-md-6 col-sm-6">
                <form id="post_form" class="form-horizontal" rel="form" method="post" action="{{ route('reset') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="password" name="old" id="old" placeholder="原密码" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="新密码" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="repassword" id="repassword" placeholder="确认新密码" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" onclick="send_data()">修改</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-sm-3"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('btv/js/bootstrapValidator.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript">
        function send_data() {
            $.ajax({
                url : " {{ route('reset') }}",
                type: "POST",
                data: $("#post_form").serialize(),
                success: function (data) {
                    bootbox.alert("修改成功",function () {
                        window.location.reload();
                    })
                },
                error: function (e) {
                    if(e.status == 400){
                        bootbox.alert("原密码错误",function () {
                            window.location.reload();
                        })
                    }else{
                        bootbox.alert("修改失败",function () {
                            window.location.reload();
                        })
                    }
                }
            })
        }
        $(function () {
            $("#post_form").bootstrapValidator({
                message: '这个值没有被验证',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields:{
                    password: {
                        validators: {
                            notEmpty: {
                                message: '密码不能为空'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须在6到30之间'
                            },
                            identical: {//相同
                                field: 'repassword', //需要进行比较的input name值
                                message: '两次密码不一致'
                            },
                        }
                    },
                    repassword: {
                        validators: {
                            notEmpty: {
                                message: '不能为空'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须在6到30之间'
                            },
                            identical: {//相同
                                field: 'password',
                                message: '两次密码不一致'
                            }
                        }
                    }
                }
            });
        });

    </script>
@endsection