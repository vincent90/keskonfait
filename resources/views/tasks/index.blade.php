@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                My tasks
            </div>

            <div class="panel-body">
                @if ($tasks->count() > 0)
                <table class="table table-striped">
                    <thead>
                    <th style="width:60%">Task name</th>
                    <th style="width:10%">Start at</th>
                    <th style="width:10%">End at</th>
                    <th style="width:5%">Status</th>
                    <th style="width:5%">&nbsp;</th>
                    <th style="width:5%">&nbsp;</th>
                    <th style="width:5%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>
                                <a href="{{ route('tasks.show', ['id' => $task->id]) }}">{{ $task->name }}</a>
                            </td>
                            <td>
                                {{$task->start_at}}
                            </td>
                            <td>
                                {{$task->end_at}}
                            </td>
                            <td>
                                {{ $task->status }}
                            </td>
                            <td>
                                @if($task->status != "Closed")
                                <form action="/tasks/{{ $task->id }}/close" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button type="submit" class="btn btn-primary">Close</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if ($task->canEdit(Auth::user()))
                                <form action="/tasks/{{ $task->id }}/edit" method="GET">
                                    <button type="submit" class="btn btn-default">Edit</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if ($task->canDestroy(Auth::user()))
                                <form action="/tasks/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="{{ $task->name }}" data-target="#confirm-delete">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>Move Along, Nothing to See Here!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
