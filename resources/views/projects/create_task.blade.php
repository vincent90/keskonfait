@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('errors.common.errors')

        <div class="panel panel-default">
            <div class="panel-heading">Edit the project : {{$project->name}}</div>
            <div class="panel-body">

                <form action="/projects/{{$project->id}}/create_task" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="project_name" class="col-sm-3 control-label">Task for</label>
                        <div class="col-sm-6">
                            <input type="text" name="project_name" id="project_name" class="form-control" disabled="true" value="{{$project->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Task name</label>
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
                        <p class="help-block">Format must be : YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="end_at" class="col-sm-3 control-label">End at</label>
                        <div class="col-sm-6">
                            <input type="text" name="end_at" id="end_at" class="form-control">
                        </div>
                        <p class="help-block">Format must be : YYYY-MM-DD</p>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to_user_id" class="col-sm-3 control-label">Assigned to</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="assigned_to_user_id" id="assigned_to_user_id">
                                <option selected="" value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                @if ($project->users->count() > 0)
                                @foreach($project->users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option selected="">Open</option>
                                <option>Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                Add task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
