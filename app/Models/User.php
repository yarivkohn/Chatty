<?php

namespace Chatty\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'last_name', 'first_name', 'location',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name){
            return $this->first_name;
        }
        return null;
    }


    public function getNameOrUserName(){
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUserName()
    {
        return $this->first_name ?:$this->username;
    }

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{md5($this->email}}?d=mm&s=40";
    }

    public function statuses()
    {
        return $this->hasMany('Chatty\Models\Status', 'user_id');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('Chatty\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('Chatty\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)
            ->get()->merge($this->friendOf()->where('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestsPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)
            ->first()
            ->pivot
            ->update([
                'accepted' => true,
            ]);
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('id', $user->id)->count();
    }

}
