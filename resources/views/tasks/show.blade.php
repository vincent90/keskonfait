@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $task->name }}
            </div>
            <div class="panel-body">
                <ul>
                    @if ($task->description != null)
                    <li>
                        <b>Description : </b>{{$task->description}}
                    </li>
                    @endif
                    <li>
                        <b>Project : </b>{{$task->project->name}}
                    </li>
                    <li>
                        <b>Start at : </b>{{$task->start_at}}
                    </li>
                    <li>
                        <b>End at : </b>{{$task->end_at}}
                    </li>
                    <li>
                        <b>Assigned to : </b>
                        @if(!$task->user->trashed())
                        {{ $task->user->fullName() }}
                        @else
                        <del>{{ $task->user()->withTrashed()->first()->fullName() }}</del>
                        @endif
                    </li>
                    <li>
                        <b>Status : </b>{{$task->status}}
                    </li>
                </ul>
                <br>
                @include('include.errors')
                <form action="/comments" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <textarea class="form-control" rows="3" name="content" id="content" placeholder="New comment..."></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="task_id" id="task_id" class="form-control" value="{{ $task->id }}">
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
                    <th style="width:60%">Comment</th>
                    <th style="width:20%">By</th>
                    <th style="width:15%">At</th>
                    <th style="width:5%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($task->comments()->orderBy('created_at','desc')->get() as $comment)
                        <tr>
                            <td>
                                {{ $comment->content }}
                            </td>
                            <td>
                                @if(!$comment->user->trashed())
                                {{ $comment->user->fullName() }}
                                @else
                                <del>{{ $comment->user()->withTrashed()->first()->fullName() }}</del>
                                @endif
                            </td>
                            <td>
                                {{ $comment->created_at }}
                            </td>
                            <td>
                                <form action="/comments/{{ $comment->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="{{ $comment->content }}" data-target="#confirm-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <div class="panel-footer">
                <form action="/tasks/{{ $task->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $task->name }}" data-target="#confirm-delete">Delete</button>
                </form>
                <form action="/tasks/{{ $task->id }}/edit" method="GET">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
            </div>
        </div>

        @include('include.revision_history', ['revisionHistory' => $task->revisionHistory])
    </div>
</div>
@endsection
