<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'npm' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('npm', $request->npm)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'npm' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken("success Login")->plainTextToken;
    }
}
