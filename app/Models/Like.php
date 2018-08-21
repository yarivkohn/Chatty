<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 8/21/18
 * Time: 12:17 PM
 */

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

	protected $table = 'likeable';

	protected $fillable = [
		'user_id'
	];


	public function likeable()
	{
		return $this->morphTo();
	}

	public function user()
	{
		return $this->belongsTo('Chatty\Models\User', 'user_id');
	}
}