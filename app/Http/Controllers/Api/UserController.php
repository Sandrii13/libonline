<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\{Validator};

class UserController extends BaseController
{

    public function register(Request $request)
    {
        $dataValidated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $dataValidated['password'] = Hash::make($request->password);

        $user = User::create($dataValidated);

        $token = $user->createToken('libonlinem7')->accessToken;

        return response()->json(['token' => $token], 200);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $success['token'] =  $user->createToken('libonlinem7')->accessToken;
            $success['user'] =  $user->email;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    }
