<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        'password' => ['required'],
        'device_name' => ['required'],
    ]);

       $user=User::where('email',$request->email)->first();

       if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

        //$user=Auth::user();

        $existingToken = DB::table('personal_access_tokens')
        ->where('tokenable_type', get_class($user))
        ->where('tokenable_id', $user->id)
        ->where('name', $request->device_name)
        ->first();

      // Existe token
        if ($existingToken) {
            return response()->json(['token' => $existingToken->token]);
        }

      // No existe tokne
        $token = $user->createToken('Celular')->plainTextToken;
        return response()->json(['token' => $token]);

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
