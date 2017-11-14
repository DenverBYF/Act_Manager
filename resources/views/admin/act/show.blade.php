@extends('adminlte::page')

@section('title', "活动记录")

@section('css')
    <link rel="stylesheet" href="{{ asset('editormd/css/editormd.preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('editormd/css/editormd.min.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-10 col-sm-10">
            <div class="markdown-body editormd-html-preview">
                <h1>{{ $act->name }}</h1>
                <HR>
                <p>
                    <span>
                        <i class="fa fa-fw fa-calendar"></i>
                        时间:&nbsp;{{ str_replace('T',' ',$act->time) }}&nbsp;&nbsp;
                        <i class="fa fa-fw fa-building"></i>
                        地点:&nbsp;{{ $act->address }}&nbsp;&nbsp;
                        <i class="fa fa-fw fa-group"></i>
                        参会情况&nbsp;{{ $act->users->count() }}&nbsp;/&nbsp;{{ $act->joinUser->count() }}
                    </span>
                </p>
                <HR>
                {!! $act->content !!}
            </div>
        </div>
        <div class="col-md-2 col-sm-2">
            <a href="{{ route('pdf',['id' => $act->id]) }}" target="_blank">
                <button class="btn btn-primary">导出PDF</button>
            </a>

        </div>
    </div>
@endsection