@extends('layouts.app')

@section('content')
<div class="row col-sm-offset-3 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $project->name }}
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                <th>Task name</th>
                <th>Description</th>
                <th>Done</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <!-- Task Name -->
                        <td class="table-text">
                            <div>{{ $task->name }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $task->description }}</div>
                        </td>
                        <td class="table-text">
                            <div>
                                @if ($task->isComplete)
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                @else
                                <!-- TODO mettre un bouton ou checkmark ou qqch du genre... -->
                                @endif
                            </div>
                        </td>
                        <td>
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete Task</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
