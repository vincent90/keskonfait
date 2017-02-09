@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('errors.common.errors')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit task</h3>
            </div>
            <div class="panel-body">
                <form action="/tasks/{{$task->id}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="project_name" class="col-sm-3 control-label">* Task for</label>
                        <div class="col-sm-6">
                            <input type="text" name="project_name" id="project_name" class="form-control" disabled="true" value="{{$task->project->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">* Task name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $task->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $task->description) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start_at" class="col-sm-3 control-label">* Start at</label>
                        <div class="col-sm-6">
                            <input type="text" name="start_at" id="start_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('start_at', $task->start_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="end_at" class="col-sm-3 control-label">* End at</label>
                        <div class="col-sm-6">
                            <input type="text" name="end_at" id="end_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('end_at', $task->end_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="user_id" class="col-sm-3 control-label">* Assigned to</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="user_id" id="user_id">
                                <option value="{{ Auth::user()->id }}" @if (old('user_id', $task->user->id) == Auth::user()->id) selected="selected" @endif>{{ Auth::user()->name }}</option>
                                @if ($task->project->users->count() > 0)
                                @foreach($task->project->users as $user)
                                <option value="{{$user->id}}" @if (old('user_id', $task->user->id) == $user->id) selected="selected" @endif>{{$user->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">* Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option @if (old('status', $task->status) == 'Open') selected="selected" @endif>Open</option>
                                <option @if (old('status', $task->status) == 'Closed') selected="selected" @endif>Closed</option>
                            </select>
                        </div>
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
