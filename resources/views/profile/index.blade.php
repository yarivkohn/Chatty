@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.block')
            <hr>

            @if(!$statuses->count())
                <p>{{ $user->getFirstnameOrUsername() }} hasn't posted anything</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}"> <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}"
                                    src="{{ $status->user->getAvatarUrl() }}"> </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='{{ route('profile.index', ['username' => $status->user->username]) }}'>
                                    {{ $status->user->getNameOrUsername() }}</a></h4>
                            <p> {{ $status->body }} </p>
                            <ul class="list-inline">
                                <li>{{  $status->created_at->diffForHumans() }}</li>
                                @if($status->user->id !== Auth::user()->id)
                                    <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
                                    <li>10 Likes</li>
                                @endif
                            </ul>
                        </div>
                        @foreach ($status->replies as $reply)
                            <div class="media" style="padding-left: 50px;">
                                <a class="pull-left" href=" {{ route('profile.index', ['username' => $reply->user->username]) }}"> <img class="media-object"
                                            alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->getAvatarUrl() }}"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h4>
                                    <p>{{ $reply->body }}</p>
                                    <ul class="list-inline">
                                        <li>{{ $reply->created_at->diffForHumans() }}</li>
                                        @if($reply->user->id !== Auth::user()->id)
                                            <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
                                            <li>4 Likes</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        @if($authUserIsFriend || Auth::user()->id === $status->user->id)
                            <form role="form" action="{{ route('status.replay', ['statusId' => $status->id]) }}" method="post">
                                <div class="form-group {{ $errors->has("replay-{$status->id}")? ' has-error' : '' }}">
                                    <textarea name="replay-{{ $status->id }}" class="form-control" rows="2" placeholder="replay..."></textarea>
                                    @if($errors->has("replay-{$status->id}"))
                                        <span class="help-block">{{ $errors->first("replay-{$status->id}") }}</span>
                                    @endif
                                </div>
                                <input type="submit" value="Replay" class="btn btn-default btn-small"> <input type="hidden" name="_token" value="{{ Session::token() }}">
                            </form>
                        @endif
                    </div>
                    <hr>
                @endforeach
            @endif

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
