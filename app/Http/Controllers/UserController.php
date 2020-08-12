<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    // returns the authenticated user for admin panel
    public function data()
    {
        return response()->json(Auth()->user(), 200);
    }

    // update user data in the database
    public function update(UserUpdateRequest $request)
    {
        $user = Auth()->user();
        $user->fill($request->all());
        $user->save();
        $data = [
            'status' => 200,
            'message' => 'successfully updated',
            'body' => $user
        ];

        return response()->json($data, $data['status']);
    }

    // update user password in the database
    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        $user = Auth()->user();
        $user->password = bcrypt($request->password);
        $user->save();
        $data = [
            'status' => 200,
            'message' => 'successfully updated',
        ];

        return response()->json($data, $data['status']);
    }
}
