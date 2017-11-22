@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>{{ $userName }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">总人数</span>
                        <span class="info-box-number">{{ $userCount }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">组别数</span>
                        <span class="info-box-number">{{ $group }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-blue-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">活动数</span>
                        <span class="info-box-number">{{ $act }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="join"><h4 class="text-success">出席活动/会议</h4></label>
                <div id="join">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名称</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $user->actsJoin as $eachAct )
                                <tr>
                                    <th>{{ $eachAct->name }}</th>
                                    <th>{{ str_replace('T', ' ', $eachAct->time) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="join"><h4 class="text-danger">缺席活动/会议</h4></label>
                <div id="join">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $user->actsNotJoin as $eachAct )
                            <tr>
                                <th>{{ $eachAct->name }}</th>
                                <th>{{ str_replace('T', ' ', $eachAct->time) }}</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop