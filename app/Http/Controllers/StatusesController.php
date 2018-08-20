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

class StatusesController extends Controller
{
    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required | max:1000',
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);

        return redirect()->route('home')->with('info', 'Status posted');
    }
}