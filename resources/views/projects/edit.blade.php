@extends('layouts.app')

@section('content')
<div class="panel-body">
    @include('errors.common.errors')

    <form action="/projects" method="PUT" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Project name</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control" value="{{$project->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="start_date" class="col-sm-3 control-label">Start date</label>
            <div class="col-sm-6">
                <input type="text" name="start_date" id="start_date" class="form-control" value="{{$project->start_date}}">
            </div>
        </div>
        <div class="form-group">
            <label for="end_date" class="col-sm-3 control-label">End date</label>
            <div class="col-sm-6">
                <input type="text" name="end_date" id="end_date" class="form-control" value="{{$project->end_date}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Save changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
