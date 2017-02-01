@extends('layouts.app')

@section('content')
<div class="panel-body">
    @include('errors.common.errors')

    <form action="/projects" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Project name</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description:</label>
            <div class="col-sm-6">
                <textarea class="form-control" rows="3" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="start_at" class="col-sm-3 control-label">Start at</label>
            <div class="col-sm-6">
                <input type="text" name="start_at" id="start_at" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="end_at" class="col-sm-3 control-label">End at</label>
            <div class="col-sm-6">
                <input type="text" name="end_at" id="end_at" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="users[]" class="col-sm-3 control-label">Users</label>
            <div class="col-sm-6">
                <select multiple class="form-control" name="users[]" id="users[]">
                    @if ($users->count() > 0)
                    <ul>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </ul>
                    @endif
                </select>
            </div>
            <p class="help-block">Select multiple users with the CTRL and Shift keys</p>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add project
                </button>
            </div>
        </div>
    </form>
</div>

@if (count($projects) > 0)
<div class="row col-sm-offset-3 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            Current projects
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                <th>Project name</th>
                <th>Start at</th>
                <th>End at</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                    <tr>
                        <td class="table-text">
                            <div>
                                <a href="{{ route('projects.show', ['id' => $project->id]) }}">{{ $project->name }}</a>
                            </div>
                        </td>
                        <td class="table-text">
                            <div>{{ $project->start_at }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $project->end_at }}</div>
                        </td>
                        <td>
                            <form action="/projects/{{ $project->id }}/edit" method="GET">
                                <button type="submit" class="btn btn-default">Edit</button>
                            </form>
                        </td>
                        <td>
                            <form action="/projects/{{ $project->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        <td class="table-text">
                            <form action="{{ route('project.create_task', ['id' => $project->id]) }}" method="GET">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>New task
                                </button>
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
