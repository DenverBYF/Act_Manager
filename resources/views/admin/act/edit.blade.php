@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('editormd/css/editormd.min.css') }}">
@endsection

@section('title', '会议记录')

@section('content_header')
    <h2>{{ $act->name }}</h2>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <form class="form-horizontal" role="form" id="act_form" method="post" action="{{ route('act.update',['id' => $act->id]) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-md-10 col-lg-10 form-group" id="editormd">
                    <textarea class="editormd-markdown-textarea" style="display:none;" id="content" name="content">{{ $act->markdown_content }}</textarea>
                    <textarea class="editormd-html-textarea" name="html_content"></textarea>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <button class="btn-primary form-control" type="submit" >保存</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('editormd/editormd.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            editor = editormd("editormd", {
                path:"{{ asset('editormd/lib') }}"+"/",
                height: 800,
                syncScrolling: "single",
                toolbarAutoFixed: false,
                saveHTMLToTextarea: true,
            });
        });
    </script>
@endsection