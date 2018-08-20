<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 7/29/18
 * Time: 9:09 PM
 */

namespace Chatty\Http\Controllers;

use Chatty\Models\Status;
use Chatty\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController  extends Controller {


	/**
	 * Post new status to your timeline
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postStatus(Request $request) {
		$this->validate($request, [
			'status' => 'required | max:1000',
		]);

		Auth::user()->statuses()->create([
			'body' => $request->input('status'),
		]);

		return redirect()->route('home')->with('info', 'Status posted');
	}

	/**
	 * Replay to a given post
	 * @param Request $request
	 * @param         $statusId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postReplay(Request $request, $statusId) {
		$this->validate($request, [
			"replay-{$statusId}" => 'required|max:1000',
		], [
			'required' => 'The reply body is required',
		]);

		$status = Status::notReplay()->find($statusId);
		if(!$status){
			return redirect()->route('home');
		}
		if(!Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user->id) {
			 return redirect('home');
		}

		$replay = Status::create([
			'body' => $request->input("replay-{$statusId}"),
			'user_id' =>Auth::user()->id,
		])->user()->associate(Auth::user());

		$status->replies()->save($replay);

		return redirect()->back();
	}
}