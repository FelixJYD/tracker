<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
       // $request->authenticate();

       // $request->session()->regenerate();

       $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

       $user=User::where('email',$request->email)->first();

       if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

        //$user=Auth::user();

        return $user->createToken("Celular")->plainTextToken;

       // return response()->noContent();

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): string
    {
        $request->user()->currentAccessToken()->delete();
		return json_encode([]);
    }
}   
