<?php

namespace App\Http\Controllers;

use App\Signup;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function createSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:signups|max:255',
            'days' => 'required|in:20,21,both',
            'games' => 'JSON',
            'other' => 'string|max:255'
        ]);

        $signup = Signup::create($request->all());

        return response()->json($signup, 201);
    }

    public function countSignups()
    {
        return response()->json(count(Signup::all()));
    }
}
