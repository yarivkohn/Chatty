<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 7/29/18
 * Time: 9:09 PM
 */

namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getSignUp()
    {
        return view('auth.signup');
    }

    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email|max:255',
            'username' => 'required|unique:users|alpha_dash|max:20',
            'password' => 'required|min:6',
        ]);

        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('home')->with('info', 'Your account has been created. You can now sign in');
    }

    public function getSignIn()
    {
        return view('auth.signin');
    }

    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if(!Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return redirect()->route('auth.signin')->with('error', 'Could not sign you in with those credentials');
        }
        return redirect()->route('home')->with('info', 'You are now signed in');
    }

    public function getSignOut()
    {
        Auth::logout();
        return redirect()->route('home')->with('info', 'Successfully signed out ');
    }
}