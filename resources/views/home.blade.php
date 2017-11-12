@extends('adminlte::page')

@section('title', '网信院')

@section('content_header')
    <h1>网络与信息安全学院本科生党支部</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">支部总人数</span>
                        <span class="info-box-number">39</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">正式党员</span>
                        <span class="info-box-number">13</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-blue-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">预备党员</span>
                        <span class="info-box-number">26</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop