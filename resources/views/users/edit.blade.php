@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit user
            </div>
            <div class="panel-body">
                @include('include.errors')
                <form action="/users/{{$user->id}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label">* First name</label>
                        <div class="col-sm-6">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">* Last name</label>
                        <div class="col-sm-6">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="col-sm-3 control-label">* Phone number</label>
                        <div class="col-sm-6">
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_image" class="col-sm-3 control-label">User image</label>
                        <div class="col-sm-6">
                            <input type="file" name="user_image" id="user_image" class="form-control" value="{{ old('user_image', $user->user_image) }}" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discord_account" class="col-sm-3 control-label">Discord account</label>
                        <div class="col-sm-6">
                            <input type="text" name="discord_account" id="discord_account" class="form-control" value="{{ old('discord_account', $user->discord_account) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">* Email</label>
                        <div class="col-sm-6">
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    @if (Auth::user()->superuser)
                    <div class="form-group">
                        <label for="superuser" class="col-sm-3 control-label">* Superuser</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="superuser" id="superuser">
                                <option value="1" @if (old('superuser', $user->superuser) == 1) selected="selected" @endif>True</option>
                                <option value="0"  @if (old('superuser', $user->superuser) == 0) selected="selected" @endif>False</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="superuser" id="superuser" value="{{ old('superuser', $user->superuser) }}" class="form-control">
                    @endif
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">* Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-3 control-label">* Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>
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
