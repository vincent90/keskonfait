@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('errors.common.errors')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit project</h3>
            </div>
            <div class="panel-body">
                <form action="/projects/{{$project->id}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">* Project name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="project_name" class="form-control" value="{{ old('name', $project->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $project->description) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start_at" class="col-sm-3 control-label">* Start at</label>
                        <div class="col-sm-6">
                            <input type="text" name="start_at" id="start_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('start_at', $project->start_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="end_at" class="col-sm-3 control-label">* End at</label>
                        <div class="col-sm-6">
                            <input type="text" name="end_at" id="end_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('end_at', $project->end_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="users[]" class="col-sm-3 control-label">Users</label>
                        <div class="col-sm-6">
                            <select multiple class="form-control" name="users[]" id="users[]">
                                @if ($users->count() > 0)
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ (collect(old('users', $project->getUserIdsAttribute()))->contains($user->id)) ? 'selected':'' }}>{{$user->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <p class="help-block">HOLD the CTRL or Shift key to ADD or REMOVE a user</p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary pull-right">
                                Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
