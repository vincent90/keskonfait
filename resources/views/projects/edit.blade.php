@extends('layouts.app')

@section('content')
<div class="panel-body">
    @include('errors.common.errors')

    <form action="/projects/{{$project->id}}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Project name</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control" value="{{$project->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description:</label>
            <div class="col-sm-6">
                <textarea class="form-control" rows="3" name="description" id="description">{{$project->description}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="start_at" class="col-sm-3 control-label">Start at</label>
            <div class="col-sm-6">
                <input type="text" name="start_at" id="start_at" class="form-control"value="{{$project->start_at}}">
            </div>
        </div>
        <div class="form-group">
            <label for="end_at" class="col-sm-3 control-label">End at</label>
            <div class="col-sm-6">
                <input type="text" name="end_at" id="end_at" class="form-control"value="{{$project->end_at}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Save project
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
