<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Auth;
use Image;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->superuser) {
            abort(403, 'Access denied');
        }

        return view('users.index', [
            'users' => User::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;

        $user->discord_account = $request->discord_account;
        $user->email = $request->email;
        $user->superuser = $request->superuser;
        $user->password = bcrypt($request->password);
        $user->save();

        $image = $request->file('user_image');
        if ($image != null) {
            $extension = $image->getClientOriginalExtension();
            $user->user_image = $user->id . '.' . $extension;
            $destinationPath = 'images/';
            $path = $destinationPath . $user->user_image;
            $file = Image::make($image->getRealPath())->resize(32, 32)->save($path);
        }
        $user->save();

        return redirect('/users/' . $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        if (!Auth::user()->superuser && Auth::id() != $user->id) {
            abort(403, 'Access denied');
        }

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditUserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $user) {
        if (!Auth::user()->superuser && Auth::id() != $user->id) {
            abort(403, 'Access denied');
        }

        $user = User::findorfail($user->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;

        $image = $request->file('user_image');
        if ($image != null) {
            $extension = $image->getClientOriginalExtension();
            $user->user_image = $user->id . '.' . $extension;
            $destinationPath = 'images/';
            $path = $destinationPath . $user->user_image;
            $file = Image::make($image->getRealPath())->resize(32, 32)->save($path);
        }

        $user->discord_account = $request->discord_account;
        $user->email = $request->email;

        // Only a superuser can update this field.
        if (Auth::user()->superuser) {
            $user->superuser = $request->superuser;
        }

        $user->password = bcrypt($request->password);

        $user->save();

        return redirect('/users/' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        if (!Auth::user()->superuser) {
            abort(403, 'Access denied');
        }

        User::findOrFail($user->id)->delete();
        return redirect('/users');
    }

}
