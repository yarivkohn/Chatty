@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.block')
            <hr>
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if(Auth::user()->hasFriendRequestsPending($user))
                <p>Waiting for {{$user->getNameOrUserName()}} to accept your request</p>
                @elseif (Auth::user()->hasFriendRequestReceived($user))
                    <a href=" {{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend's request</a>
                @elseif (Auth::user()->isFriendWith($user))
                    <p>You and {{ $user->getNameOrUsername() }} are fiends</p>
                @elseif(Auth::user()->id !== $user->id)
                    <a href="{{ route('friend.add', ['username'=>$user->username]) }}" class="btn btn-primary">Add as friend</a>
            @endif

            <h4>{{$user->getFirstNameOrUsername()}}'s friends.</h4>
            @if(!$user->friends()->count())
                <p>{{$user->getFirstNameOrUsername()}} has no friends</p>
                @else
                @foreach($user->friends() as $user)
                @endforeach
            @endif
        </div>
    </div>
@stop
