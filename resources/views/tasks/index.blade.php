@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right">
                @can('task-create')
                    <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create New Task</a>
                @endcan
            </div>
        </div>
    </div>

    <br>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        <br>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Имя клиента</th>
            <th>Почта клиента</th>
            <th>Вложение</th>
            <th>Дата создания</th>
            <th>Дата и время старта</th>
            <th>Дата и время завершения</th>
            <th width="280px">Статус</th>
        </tr>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id}}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->client_name }}</td>
                <td>{{ $task->client_email }}</td>
                <td>
                    @if($task->file_name)
                        <a href="/storage/{{ $task->file_name }}">{{$task->file_name}}</a>
                    @endif
                </td>
                <td>{{ $task->created_at }}</td>
                <td>{{ $task->started_at }}</td>
                <td>{{ $task->ended_at }}</td>
                <td>
                    @can('task-edit')
                        @if($task->done_flag)
                            готово
                        @else
                            <form action="{{ route('tasks.done') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Отметить сделаной</button>
                                <input type="hidden" name="done" value="{{$task->id}}">
                            </form>
                        @endif
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>

    {!! $tasks->links() !!}

@endsection
