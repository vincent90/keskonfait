@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit task
            </div>
            <div class="panel-body">
                @include('include.messages')

                <form action="/tasks/{{$task->id}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <input type="hidden" name="project_id" id="project_id" class="form-control" value="{{ $task->project->id }}">

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-3 control-label">* Task name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $task->name) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $task->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('start_at') ? ' has-error' : '' }}">
                        <label for="start_at" class="col-sm-3 control-label">* Start at</label>
                        <div class="col-sm-6">
                            <input type="text" name="start_at" id="start_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('start_at', $task->start_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>

                    <div class="form-group{{ $errors->has('end_at') ? ' has-error' : '' }}">
                        <label for="end_at" class="col-sm-3 control-label">* End at</label>
                        <div class="col-sm-6">
                            <input type="text" name="end_at" id="end_at" class="form-control datepicker" data-date-format="yyyy-mm-dd" value="{{ old('end_at', $task->end_at) }}">
                        </div>
                        <p class="help-block">YYYY-MM-DD</p>
                    </div>

                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        <label for="user_id" class="col-sm-3 control-label">* Assigned to</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="user_id" id="user_id">
                                @if ($task->project->users->count() > 0)
                                @foreach($task->project->users()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get() as $user)
                                <option value="{{$user->id}}" @if (old('user_id') == $user->id) selected="selected" @endif>{{ $user->fullName() }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
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
                            <button type="submit" class="btn btn-primary">
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
