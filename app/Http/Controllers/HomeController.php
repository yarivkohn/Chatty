<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 7/29/18
 * Time: 9:09 PM
 */

namespace Chatty\Http\Controllers;

use Chatty\Models\Status;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            $statuses = Status::notReplay()->where(function($query){
                return $query->where('user_id', Auth::user()->id)
                    ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            return view('timeline.index')
                ->with('statuses', $statuses);
        }
        return view('home');
    }
}