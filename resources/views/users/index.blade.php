@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                All users
            </div>
            <div class="panel-body">
                @if ($users->count() > 0)
                <table class="table table-striped">
                    <thead>
                    <th style="width:25%">Name</th>
                    <th style="width:15%">Phone number</th>
                    <th style="width:20%">Discord account</th>
                    <th style="width:30%">Email</th>
                    <th style="width:5%">&nbsp;</th>
                    <th style="width:5%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', ['id' => $user->id]) }}">
                                    @if ($user->user_image)
                                    <img src="{{URL::asset('images/' . $user->user_image)}}" alt="User image">
                                    @endif
                                    {{ $user->fullName() }}
                                </a>
                            </td>
                            <td>
                                {{ $user->phone_number }}
                            </td>
                            <td>
                                {{ $user->discord_account }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                <form action="/users/{{ $user->id }}/edit" method="GET">
                                    <button type="submit" class="btn btn-default">Edit</button>
                                </form>
                            </td>
                            <td>
                                <form action="/users/{{ $user->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-item-to-delete="{{ $user->fullName() }}" data-target="#confirm-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
