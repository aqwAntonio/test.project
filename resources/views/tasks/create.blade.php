@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Task</h2>
            </div>
            <div class="pull-right">
                @can('task-list')
                    <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
                @endcan
            </div>
        </div>
    </div>

    <br>
    @if ($errors->any())

        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        <br>
    @endif

    {{ Form::open(array('files'=>true, 'route' => array('tasks.store')))}}
    {{Form::token()}}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Идентификатор:</strong>
                {{Form::number('id', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Тема:</strong>
                {{Form::text('name', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Описание:</strong>
                {{Form::textarea('description', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Вложение:</strong>
                {{Form::file('file', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Время старта задачи:</strong>
                {{Form::datetimeLocal('started_at', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Время завершения задачи:</strong>
                {{Form::datetimeLocal('ended_at', null, ['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

    {{Form::close()}}

@endsection
