@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $user->fullName() }}
            </div>

            <div class="panel-body">
                <ul>
                    <li>
                        <b>Phone number : </b>
                        {{ $user->phone_number }}
                    </li>
                    <li>
                        <b>User image : </b>
                        @if ($user->user_image)
                        <img src="{{URL::asset('images/' . $user->user_image)}}" alt="User image">
                        @endif
                    </li>
                    <li>
                        <b>Discord user account : </b>
                        {{ $user->discord_user }}
                    </li>
                    <li>
                        <b>Discord channel : </b>
                        {{ $user->discord_channel }}
                    </li>
                    <li>
                        <b>Email : </b>
                        <a href="mailto:'{{ $user->email }}'" target="_top">{{ $user->email }}</a>
                    </li>
                    <li>
                        <b>Superuser : </b>
                        @if ($user->superuser) yes @else no @endif
                    </li>
                    <li>
                        <b>Account status : </b>
                        @if ($user->active) active @else inactive @endif
                    </li>
                </ul>
            </div>

            <div class="panel-footer">
                @if (Auth::user()->superuser)
                <form action="/users/{{ $user->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-item-to-delete="{{ $user->fullName() }}" data-target="#confirm-delete">Delete</button>
                </form>
                @endif
                @if (Auth::user()->superuser || Auth::user()->id == $user->id)
                <form action="/users/{{ $user->id }}/edit" method="GET">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
