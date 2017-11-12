@extends('adminlte::page')

@section('title', '会议记录')

@section('content_header')
    <h2>{{ $act->name }}</h2>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('act.update',['id' => $act->id]) }}" id="act_form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group col-md-10 col-sm-10">
                    <label for="content">会议记录</label>
                    <textarea id="content" name="content" rows="20" class="form-control">{{ empty($act->content)?"":$act->content }}</textarea>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <button class="btn-primary form-control" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js ') }}"></script>
    <script type="text/javascript">

    </script>
@endsection