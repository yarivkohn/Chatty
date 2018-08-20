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
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query = $request->input('query');
        if(empty($query)){
            return redirect()->route()->route('home')->with('info', 'Your search came back with no results');
        }
        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), "LIKE", "%{$query}%")
            ->orWhere("username", "LIKE", "%{$query}%")
            ->get();
        return view('search.results')->with('users', $users);
    }
}