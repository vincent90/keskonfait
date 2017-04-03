@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $project->name }}
            </div>
            <div class="panel-body">
                <ul>
                    <li>
                        <b>Description : </b>
                        {{ $project->description }}
                    </li>
                    <li>
                        <b>Project manager : </b>
                        <a href="{{ route('users.show', ['id' => $project->user->id]) }}">{{ $project->user->fullName() }}</a>
                    </li>
                    <li>
                        <b>Start at : </b>
                        {{ $project->start_at }}
                    </li>
                    <li>
                        <b>End at : </b>
                        {{ $project->end_at }}
                    </li>
                    @if ($project->users->count() > 0)
                    <li><b>Users in this project : </b>
                        <ul>
                            @foreach($project->users()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get() as $user)
                            <li>
                                @if($user->active)
                                <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->fullName() }}</a>
                                @else
                                <del><a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->fullName() }}</a></del>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="panel-footer">
                @if ($project->canDestroy(Auth::user()))
                <form action="/projects/{{ $project->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $project->name }}" data-target="#confirm-delete">Delete</button>
                </form>
                @endif
                @if ($project->canEdit(Auth::user()))
                <form action="/projects/{{ $project->id }}/edit" method="GET">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                New task
            </div>
            <div class="panel-body">
                <form action="/tasks" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <input type="hidden" name="project_id" id="project_id" class="form-control" value="{{ $project->id }}">

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-3 control-label">* Task name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('task_id') ? ' has-error' : '' }}">
                        <label for="task_id" class="col-sm-3 control-label">Subtask of</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="task_id" id="task_id">
                                <option value="-1" @if (old('task_id') == '-1') selected="selected" @endif></option>
                                @if ($project->tasks->count() > 0)
                                {{--@php foreach($project->tasks()->orderBy('start_at','asc')->orderBy('end_at','asc')->get() as $task) renderSelectOptions($task, 0); @endphp--}}
                                @endif
                            </select>
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

                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        <label for="user_id" class="col-sm-3 control-label">* Assigned to</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="user_id" id="user_id">
                                @if ($project->users->count() > 0)
                                @foreach($project->users()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get() as $user)
                                <option value="{{$user->id}}" @if (old('user_id') == $user->id) selected="selected" @endif>{{ $user->fullName() }} @if(!$user->active) - [INACTIVE ACCOUNT]@endif</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status" class="col-sm-3 control-label">* Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option @if (old('status') == 'Open') selected="selected" @endif>Open</option>
                                <option @if (old('status') == 'Closed') selected="selected" @endif>Closed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                Create task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($project->tasks->count() > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Tasks for this project
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <th style="width:45%">Task name</th>
                    <th style="width:10%">Start at</th>
                    <th style="width:10%">End at</th>
                    <th style="width:20%">Assigned to</th>
                    <th style="width:5%">Status</th>
                    <th style="width:5%">&nbsp;</th>
                    <th style="width:5%">&nbsp;</th>
                    </thead>
                    <tbody>
{{--                        @php foreach($project->tasks()->orderBy('start_at','asc')->orderBy('end_at', 'asc')->get() as $task) renderTask($task, 0); @endphp--}}
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @include('include.revision_history', ['revisionHistory' => $project->revisionHistory])
    </div>
</div>

{{--@php--}}
    {{--function renderSelectOptions($task, $i) {--}}
        {{--$prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $i);--}}
        {{--if($task->id == old('task_id')){--}}
            {{--echo '<option value="' . $task->id . '" selected="">' . $prefix . $task->name . '</option>';--}}
        {{--} else {--}}
            {{--echo '<option value="' . $task->id . '">' . $prefix . $task->name . '</option>';--}}
        {{--}--}}
        {{--if ( $task->children()->count() > 0 ) {--}}
            {{--foreach($task->children()->orderBy('start_at','asc')->get() as $subTask) {--}}

                {{--$prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ++$i);--}}
                {{--if($subTask->id == old('task_id')){--}}
                    {{--echo '<option value="' . $subTask->id . '" selected="">' . $prefix . $subTask->name . '</option>';--}}
                {{--} else {--}}
                    {{--echo '<option value="' . $subTask->id . '">' . $prefix . $subTask->name . '</option>';--}}
                {{--}--}}
            {{--}--}}
        {{--}--}}
    {{--}--}}

    {{--function renderTask($task, $i) {--}}
        {{--$prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $i);--}}
        {{--echo '<tr>';--}}
            {{--echo '<td>';--}}
                {{--echo '<a href="/tasks/' . $task->id . '">' . $prefix . $task->name . '</a>';--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $task->start_at;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $task->end_at;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if($task->user->active) {--}}
                {{--echo '<a href="' . route('users.show', ['id' => $task->user->id]) . '">' . $task->user->fullName() . '</a>';--}}
                {{--}   else {--}}
                {{--echo '<del><a href="' . route('users.show', ['id' => $task->user->id]) . '">' . $task->user->fullName() . '</a></del>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $task->status;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if ($task->canEdit(Auth::user())) {--}}
                {{--echo '<form action="/tasks/' . $task->id . '/edit" method="GET">';--}}
                    {{--echo '<button type="submit" class="btn btn-default">Edit</button>';--}}
                    {{--echo '</form>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if ($task->canDestroy(Auth::user())) {--}}
                {{--echo '<form action="/tasks/' . $task->id . '" method="POST">';--}}
                    {{--echo csrf_field();--}}
                    {{--echo method_field('DELETE');--}}
                    {{--echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="' . $task->name . '" data-target="#confirm-delete">Delete</button>';--}}
                    {{--echo '</form>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '</tr>';--}}
        {{--if ( $task->children()->count() > 0 ) {--}}
        {{--foreach($task->children()->orderBy('start_at','asc')->get() as $t){--}}
            {{--$prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ++$i);--}}

                {{--echo '<tr>';--}}
            {{--echo '<td>';--}}
                {{--echo '<a href="/tasks/' . $t->id . '">' . $prefix . $t->name . '</a>';--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $t->start_at;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $t->end_at;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if($t->user->active) {--}}
                {{--echo '<a href="' . route('users.show', ['id' => $t->user->id]) . '">' . $t->user->fullName() . '</a>';--}}
                {{--}   else {--}}
                {{--echo '<del><a href="' . route('users.show', ['id' => $t->user->id]) . '">' . $t->user->fullName() . '</a></del>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--echo $t->status;--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if ($t->canEdit(Auth::user())) {--}}
                {{--echo '<form action="/tasks/' . $t->id . '/edit" method="GET">';--}}
                    {{--echo '<button type="submit" class="btn btn-default">Edit</button>';--}}
                    {{--echo '</form>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '<td>';--}}
                {{--if ($t->canDestroy(Auth::user())) {--}}
                {{--echo '<form action="/tasks/' . $t->id . '" method="POST">';--}}
                    {{--echo csrf_field();--}}
                    {{--echo method_field('DELETE');--}}
                    {{--echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="' . $t->name . '" data-target="#confirm-delete">Delete</button>';--}}
                    {{--echo '</form>';--}}
                {{--}--}}
                {{--echo '</td>';--}}
            {{--echo '</tr>';--}}
        {{--}--}}
        {{--}--}}
    {{--}--}}

{{--@endphp--}}
@endsection
