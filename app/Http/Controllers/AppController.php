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

        if (Auth::check()) {
            $user = Auth::user()->toArray();
        } elseif ($request->invitation_token) {
            $user = User::where('invitation_token', $request->invitation_token)->first();
        }

        return view('layout', compact('user'));
    }
}
