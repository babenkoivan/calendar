<?php

namespace App\Http\Controllers;

use App\Notifications\Invitation;
use App\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
            return Auth::user();
        } else {
            throw new HttpResponseException(response()->json('Wrong email or password', 400));
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    private function makeInvitationToken(array $data)
    {
        return md5($data['name'].$data['email'].'q64G,4)jD96m');
    }

    public function invite(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = new User();
        } elseif ($user->is_active) {
            throw new HttpResponseException(response()->json('User has already been registered', 400));
        }

        $user->fill($request->all());
        $user->invitation_token = $this->makeInvitationToken($request->all());
        $user->is_active = 0;
        $user->password = bcrypt(uniqid());
        $user->save();

        $user->notify(new Invitation($user));
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'invitation_token' => 'required'
        ]);

        $user = User::where('invitation_token', $request->invitation_token)->first();

        if (!$user) {
            throw new HttpResponseException(response()->json('User not found', 400));
        }

        $user->password = bcrypt($request->password);
        $user->is_active = 1;
        $user->invitation_token = '';
        $user->save();

        Auth::login($user);

        return $user;
    }
}
