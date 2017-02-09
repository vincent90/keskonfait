@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">

        <form action="/projects/{{ $project->id }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $project->name }}" data-target="#confirm-delete">Delete</button>
        </form>
        <form action="/projects/{{ $project->id }}/edit" method="GET">
            <button type="submit" class="btn btn-default pull-right">Edit</button>
        </form>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $project->name }}</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @if ($project->description != null)
                    <li><b>Description : </b>{{$project->description}}</li>
                    @endif
                    <li><b>Project manager : </b>{{$project->name}}</li>
                    <li><b>Start at : </b>{{$project->start_at}}</li>
                    <li><b>End at : </b>{{$project->end_at}}</li>
                    @if ($project->users->count() > 0)
                    <li><b>Users in this project : </b>
                        <ul>
                            @foreach($project->users as $user)
                            <li>{{$user->name}}</li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="panel-footer clearfix">
                <form action="{{ route('project.create_task', ['id' => $project->id]) }}" method="GET">
                    <button type="submit" class="btn btn-primary pull-right">
                        New task
                    </button>
                </form>
            </div>
        </div>

        @if ($project->tasks->count() > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tasks for this project</h3>
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
                        @foreach ($project->tasks()->orderBy('start_at','asc')->get() as $task)
                        <tr>
                            <td>
                                <a href="{{ route('tasks.show', ['id' => $task->id]) }}">{{ $task->name }}</a>
                            </td>
                            <td>
                                {{$task->start_at}}
                            </td>
                            <td>
                                {{$task->end_at}}
                            </td>
                            <td>
                                {{ $task->user->name }}
                            </td>
                            <td>
                                {{ $task->status }}
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}/edit" method="GET">
                                    <button type="submit" class="btn btn-default pull-right">Edit</button>
                                </form>
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $task->name }}" data-target="#confirm-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif


        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Revision history (Click to expand)</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    @foreach($project->revisionHistory as $history)
                    @if($history->key == 'created_at' && !$history->old_value)
                    <li>{{ $history->userResponsible()->name }} created this resource at {{ $history->newValue() }}</li>
                    @else
                    <li>{{ $history->userResponsible()->name }} changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }} at {{ $history->created_at}}</li>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
