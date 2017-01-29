@extends('layouts.app')

@section('content')
    <div class="panel-body">
        @include('errors.common.errors')

        <form action="/tasks" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Task name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Task</label>
                <div class="col-sm-6">
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add task
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (count($tasks) > 0)
    <div class="row col-sm-offset-3 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
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
    @endif
@endsection
