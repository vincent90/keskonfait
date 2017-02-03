@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">My tasks</div>
            <div class="panel-body">

                <table class="table table-striped">
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
                            <td>
                                {{ $task->name }}
                            </td>
                            <td>
                                {{ $task->description }}
                            </td>
                            <td>
                                {{ $task->start_at }}
                            </td>
                            <td>
                                {{ $task->end_at }}
                            </td>
                            <td>
                                {{ $task->status }}
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
