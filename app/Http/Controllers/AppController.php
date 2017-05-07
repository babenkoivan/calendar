<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $user = null;

        if ($request->invitation_token) {
            Auth::logout();

            $user = User::where('invitation_token', $request->invitation_token)->first();
        } elseif (Auth::check()) {
            $user = Auth::user()->toArray();
        }

        return view('layout', compact('user'));
    }
}
