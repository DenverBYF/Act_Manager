@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>ACT_Manager</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red-gradient"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">总人数</span>
                        <span class="info-box-number">{{ $user }}</span>
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
        </div>
    </div>
@stop