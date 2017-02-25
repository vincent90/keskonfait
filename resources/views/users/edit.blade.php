@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        @include('include.messages')

        <div class="panel panel-default">
            <div class="panel-heading">
                Edit user
            </div>

            <div class="panel-body">
                <form action="/users/{{$user->id}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-sm-3 control-label">* First name</label>
                        <div class="col-sm-6">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-sm-3 control-label">* Last name</label>
                        <div class="col-sm-6">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label for="phone_number" class="col-sm-3 control-label">* Phone number</label>
                        <div class="col-sm-6">
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('user_image') ? ' has-error' : '' }}">
                        <label for="user_image" class="col-sm-3 control-label">New user image</label>
                        <div class="col-sm-6">
                            <input type="file" name="user_image" id="user_image" class="form-control" value="{{ old('user_image', $user->user_image) }}" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('discord_user') ? ' has-error' : '' }}">
                        <label for="discord_user" class="col-sm-3 control-label">Discord user account</label>
                        <div class="col-sm-6">
                            <input type="text" name="discord_user" id="discord_user" class="form-control" value="{{ old('discord_user', $user->discord_user) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('discord_channel') ? ' has-error' : '' }}">
                        <label for="discord_channel" class="col-sm-3 control-label">Discord channel ID</label>
                        <div class="col-sm-6">
                            <input type="text" name="discord_channel" id="discord_channel" class="form-control" value="{{ old('discord_channel', $user->discord_channel) }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-3 control-label">* Email</label>
                        <div class="col-sm-6">
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    @if (Auth::user()->superuser)
                    <div class="form-group{{ $errors->has('superuser') ? ' has-error' : '' }}">
                        <label for="superuser" class="col-sm-3 control-label">* Superuser</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="superuser" id="superuser">
                                <option value="1" @if (old('superuser', $user->superuser) == 1) selected="selected" @endif>True</option>
                                <option value="0"  @if (old('superuser', $user->superuser) == 0) selected="selected" @endif>False</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                        <label for="active" class="col-sm-3 control-label">* Active</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="active" id="active">
                                <option value="1" @if (old('active', $user->active) == 1) selected="selected" @endif>True</option>
                                <option value="0"  @if (old('active', $user->active) == 0) selected="selected" @endif>False</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="superuser" id="superuser" value="{{ old('superuser', $user->superuser) }}" class="form-control">
                    <input type="hidden" name="active" id="active" value="{{ old('active', $user->active) }}" class="form-control">
                    @endif

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
