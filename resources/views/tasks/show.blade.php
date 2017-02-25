@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $task->name }}
            </div>

            <div class="panel-body">
                <ul>
                    <li>
                        <b>Description : </b>
                        {{ $task->description }}
                    </li>
                    <li>
                        <b>Project : </b>
                        <a href="{{ route('projects.show', ['id' => $task->project->id]) }}">{{ $task->project->name }}</a>
                    </li>
                    <li>
                        <b>Start at : </b>
                        {{ $task->start_at }}
                    </li>
                    <li>
                        <b>End at : </b>
                        {{ $task->end_at }}
                    </li>
                    <li>
                        <b>Assigned to : </b>
                        @if ($task->user->active)
                        <a href="{{ route('users.show', ['id' => $task->user->id]) }}">{{ $task->user->fullName() }}</a> ->
                        @else
                        <del><a href="{{ route('users.show', ['id' => $task->user->id]) }}">{{ $task->user->fullName() }}</a></del> ->
                        @endif
                        <a href="mailto:'{{ $task->user->email }}'?Subject=About the task : '{{ $task->name }}'" target="_top">Send him/her an email</a>
                    </li>
                    <li>
                        <b>Status : </b>
                        {{ $task->status }}
                    </li>
                </ul>

                <br>
                <form action="/comments" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
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
                                @if ($comment->user->active)
                                <a href="{{ route('users.show', ['id' => $comment->user->id]) }}">{{ $comment->user->fullName() }}</a>
                                @else
                                <del><a href="{{ route('users.show', ['id' => $comment->user->id]) }}">{{ $comment->user->fullName() }}</a></del>
                                @endif
                            </td>
                            <td>
                                {{ $comment->created_at }}
                            </td>
                            <td>
                                @if ($comment->canDestroy(Auth::user()))
                                <form action="/comments/{{ $comment->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="{{ $comment->content }}" data-target="#confirm-delete">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="panel-footer">
                @if ($task->canDestroy(Auth::user()))
                <form action="/tasks/{{ $task->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $task->name }}" data-target="#confirm-delete">Delete</button>
                </form>
                @endif
                @if ($task->canEdit(Auth::user()))
                <form action="/tasks/{{ $task->id }}/edit" method="GET">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
                @endif
            </div>
        </div>

        @include('include.revision_history', ['revisionHistory' => $task->revisionHistory])
    </div>
</div>
@endsection
