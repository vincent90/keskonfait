@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                New project
            </div>

            <div class="panel-body">
                <form action="/projects" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-3 control-label">* Project name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="project_name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('start_at') ? ' has-error' : '' }}">
                        <label for="start_at" class="col-sm-3 control-label">* Start at</label>
                        <div class="col-sm-6">
                            <input type="text" name="start_at" id="start_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('start_at') }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>

                    <div class="form-group{{ $errors->has('end_at') ? ' has-error' : '' }}">
                        <label for="end_at" class="col-sm-3 control-label">* End at</label>
                        <div class="col-sm-6">
                            <input type="text" name="end_at" id="end_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('end_at') }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>

                    <div class="form-group{{ $errors->has('users[]') ? ' has-error' : '' }}">
                        <label for="users[]" class="col-sm-3 control-label">Users</label>
                        <div class="col-sm-6">
                            <select multiple class="form-control" name="users[]" id="users[]">
                                @if ($users->count() > 0)
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ (collect(old('users'))->contains($user->id)) ? 'selected':'' }}>{{ $user->fullName()}} @if(!$user->active) - [INACTIVE ACCOUNT]@endif</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <p class="help-block">HOLD the CTRL or Shift key to ADD or REMOVE a user</p>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                Create project
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($projects) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                My projects
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <th style="width:60%">Project name</th>
                    <th style="width:10%">Start at</th>
                    <th style="width:10%">End at</th>
                    <th style="width:20%">Project manager</th>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <td>
                                <a href="{{ route('projects.show', ['id' => $project->id]) }}">{{ $project->name }}</a>
                            </td>
                            <td>
                                {{$project->start_at}}
                            </td>
                            <td>
                                {{$project->end_at}}
                            </td>
                            <td>
                                @if($project->user->active)
                                {{$project->user->fullName() }}
                                @else
                                <del>{{$project->user->fullName() }}</del>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
