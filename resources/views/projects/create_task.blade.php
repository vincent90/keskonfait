@extends('layouts.app')

@section('content')
<div class="panel-body">
    @include('errors.common.errors')

    <form action="/projects/{{$project->id}}/create_task" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Task for project</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control" disabled="true" value="{{$project->name}}">
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
