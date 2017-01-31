@extends('layouts.app')

@section('content')
<div class="panel-body">
    @include('errors.common.errors')

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
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-6">
                <input type="text" name="description" id="description" class="form-control">
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
                    <i class="fa fa-plus"></i> Add task
                </button>
                <button type="button" id="cancel-btn" class="btn btn-default">
                    <i class="fa fa-plus"></i> Cancel
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById("cancel-btn").onclick = function () {
        window.history.back();
    };
</script>
@endsection
