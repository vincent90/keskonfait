@extends('layouts.app')

@section('content')
<div class="row col-sm-offset-3 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>{{ $project->name }}</b> - {{ $project->description }}
        </div>

        <div class="panel-body">
            <h4>Project manager : <b>{{ $project->manager()->name }}</b></h4>

            <h4>Project manager's little bitches :</h4>
            @if ($project->users->count() > 0)
            <ul>
                @foreach($project->users as $user)
                <li>{{$user->name}}</li>
                @endforeach
            </ul>
            @endif

            <table class="table table-striped task-table">
                <thead>
                <th>Task name</th>
                <th>Description</th>
                <th>Start at</th>
                <th>End at</th>
                <th>Status</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <!-- Task Name -->
                        <td class="table-text">
                            <div>{{ $task->name }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $task->description }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $task->start_at }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $task->end_at }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $task->status }}</div>
                        </td>
                        <td>
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <button type="button" id="bo-back-btn" class="btn btn-default">
        <i class="fa fa-plus"></i> Back
    </button>
</div>

<script>
    document.getElementById("bo-back-btn").onclick = function () {
        window.history.back();
    };
</script>
@endsection
