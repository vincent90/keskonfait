@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">

        <form action="/tasks/{{ $task->id }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $task->name }}" data-target="#confirm-delete">Delete</button>
        </form>
        <form action="/tasks/{{ $task->id }}/edit" method="GET">
            <button type="submit" class="btn btn-default pull-right">Edit</button>
        </form>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $task->name }}</h3>
            </div>
            <div class="panel-body">

                <ul>
                    @if ($task->description != null)
                    <li><b>Description : </b>{{$task->description}}</li>
                    @endif
                    <li><b>For project : </b>{{$task->project->name}}</li>
                    <li><b>Start at : </b>{{$task->start_at}}</li>
                    <li><b>End at : </b>{{$task->end_at}}</li>
                    <li><b>Assigned to : </b>{{$task->user->name}}</li>
                    <li><b>Status to : </b>{{$task->status}}</li>
                </ul>

                <br>

                <form action="/tasks/{{$task->id}}/create_comment" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <textarea class="form-control" rows="3" name="content" id="content" placeholder="New comment..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-11">
                            <button type="submit" class="btn btn-default pull-right">
                                Post comment
                            </button>
                        </div>
                    </div>
                </form>

                <br>

                @if ($task->comments->count() > 0)
                <table class="table table-striped">
                    <thead>
                    <th style="width:55%">Comment</th>
                    <th style="width:20%">By</th>
                    <th style="width:15%">At</th>
                    <th style="width:10%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($task->comments()->orderBy('created_at','desc')->get() as $comment)
                        <tr>
                            <td>
                                {{ $comment->content }}
                            </td>
                            <td>
                                {{ $comment->user->name }}
                            </td>
                            <td>
                                {{ $comment->created_at }}
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}/delete_comment/{{ $comment->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $comment->content }}" data-target="#confirm-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Revision history (Click to expand)</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    @foreach($task->revisionHistory as $history)
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
