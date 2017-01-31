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
            <label for="start_date" class="col-sm-3 control-label">Start date</label>
            <div class="col-sm-6">
                <input type="text" name="start_date" id="start_date" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="end_date" class="col-sm-3 control-label">End date</label>
            <div class="col-sm-6">
                <input type="text" name="end_date" id="end_date" class="form-control">
            </div>
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
                <th>Start date</th>
                <th>End date</th>
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
                            <div>{{ $project->start_date }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $project->end_date }}</div>
                        </td>
                        <td>
                            <form action="/projects/{{ $project->id }}/edit" method="GET">
                                <button type="submit" class="btn btn-default">Edit project</button>
                            </form>
                        </td>
                        <td>
                            <form action="/projects/{{ $project->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete project</button>
                            </form>
                        </td>
                        <td class="table-text">
                            <div>
                                <a href="{{ route('project.create_task', ['id' => $project->id]) }}">+ Task</a>
                            </div>
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
