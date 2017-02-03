@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><b>{{ $task->name }}</b> @if ($task->description != null) - {{ $task->description }}@endif</div>
            <div class="panel-body">
                <ul>
                    <li><b>For project :</b> {{$task->project()->name}}</li>
                    <li><b>Start at :</b> {{$task->start_at}}</li>
                    <li><b>End at :</b> {{$task->end_at}}</li>
                    <li><b>Assigned to :</b> {{$task->assignedTo()->name}}</li>
                    <li><b>Status to :</b> {{$task->status}}</li>
                </ul>

                <form action="/tasks/{{$task->id}}/create_comment" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <textarea class="form-control" rows="3" name="content" id="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-default pull-right">
                                Post comment
                            </button>
                        </div>
                    </div>
                </form>

                <table class="table table-striped">
                    <thead>
                    <th style="width:55%">Comment</th>
                    <th style="width:10%">Date</th>
                    <th style="width:25%">Created by</th>
                    <th style="width:10%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($task->comments() as $comment)
                        <tr>
                            <td>
                                {{ $comment->content }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($comment->created_ad)->format('Y-m-d') }}
                            </td>
                            <td>
                                {{ $comment->user()->name }}
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}/delete_comment/{{ $comment->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger pull-right" onclick="beforeDelete(this.parentElement, '{{ $comment->content }}');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    beforeDelete = function (form, taskName) {
    if (confirm("Are you sure you want to delete the comment : " + taskName + " ?")) {
    form.submit();
    }
    }
</script>
@endsection
