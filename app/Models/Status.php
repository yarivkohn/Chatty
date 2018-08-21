<?php
/**
 * Created by PhpStorm.
 * User: yariv
 * Date: 8/20/18
 * Time: 8:24 AM
 */

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('Chatty\Models\User', 'user_id');
    }

	/**
	 * Filter post w/o parent id
	 * @param $query
	 * @return mixed
	 */
	public function scopeNotReplay($query)
	{
		return $query->whereNull('parent_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies()
	{
		return $this->hasMany('Chatty\Models\Status', 'parent_id');
	}

	/**
	 */
	public function likes()
	{
		return $this->morphMany('Chatty\Models\Like', 'likeable');
	}
}