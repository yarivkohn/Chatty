<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 7/29/18
 * Time: 9:09 PM
 */

namespace Chatty\Http\Controllers;

use Chatty\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if(empty($user)){
            abort(404);
        }

        $statuses = $user->statuses()->notReplay()->get();

        return view('profile.index')
	        ->with('user', $user)
	        ->with('statuses', $statuses)
	        ->with('authUserIsFriend', Auth::user()->isFriendWith($user))  ;
    }

    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'alpha|max:50',
            'last_name' => 'alpha|max:50',
            'location' => 'max:20',
        ]);

        $res = Auth::user()->update([
            'first_name'=> $request->input('first_name'),
            'last_name'=> $request->input('last_name'),
            'location'=> $request->input('location'),
            ]
        );
        if($res){
            return redirect()->route('home')->with('info', 'Profile updated successfully');
        }
        return redirect()->route('home')->with('error', 'Update profile failed');

    }
}