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
        'body'
    ];

    public function user()
    {
        return $this->belongsTo('Chatty\Models\User', 'user_id');
    }
}