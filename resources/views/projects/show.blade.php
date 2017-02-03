@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><b>{{ $project->name }}</b> @if ($project->description != null) - {{ $project->description }}@endif</div>
            <div class="panel-body">
                <h4>Project manager : <b>{{ $project->manager()->name }}</b></h4>

                <h4>Users in this project :</h4>
                @if ($project->users->count() > 0)
                <ul>
                    @foreach($project->users as $user)
                    <li>{{$user->name}}</li>
                    @endforeach
                </ul>
                @endif

                <table class="table table-striped">
                    <thead>
                    <th>Task name</th>
                    <th>Start at</th>
                    <th>End at</th>
                    <th>Assigned to</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>
                                {{ $task->name }}
                            </td>
                            <td>
                                {{ $task->start_at }}
                            </td>
                            <td>
                                {{ $task->end_at }}
                            </td>
                            <td>
                                {{ $task->assignedTo()->name }}
                            </td>
                            <td>
                                {{ $task->status }}
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}/edit" method="GET">
                                    <button type="submit" class="btn btn-default">Edit task</button>
                                </form>
                            </td>
                            <td>
                                <form action="/tasks/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger" onclick="beforeDelete(this.parentElement, '{{ $task->name }}');">Delete</button>
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
    if (confirm("Are you sure you want to delete the task : " + taskName + " ?")) {
    form.submit();
    }
    }
</script>
@endsection
