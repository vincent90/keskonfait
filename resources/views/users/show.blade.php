@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $user->fullName() }}
            </div>
            <div class="panel-body">
                <ul>
                    <li><b>Phone number : </b>{{ $user->phone_number }}</li>
                    @if ($user->user_image)
                    <li><b>User image : </b><img src="{{URL::asset('images/' . $user->user_image)}}" alt="User image"></li>
                    @endif
                    <li><b>Discord account : </b>{{ $user->discord_account }}</li>
                    <li><b>Email : </b>{{ $user->email }}</li>
                    <li><b>Superuser : </b>@if ($user->superuser) yes @else no @endif</li>
                </ul>
            </div>
            <div class="panel-footer">
                <form action="/users/{{ $user->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $user->fullName() }}" data-target="#confirm-delete">Delete</button>
                </form>
                <form action="/users/{{ $user->id }}/edit" method="GET">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
