@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{ route('status.post') }}" method="post">
                <div class="form-group {{ $errors->has('status')? ' has-error' : '' }}">
                    <textarea placeholder="What's on your mind?"
                            name="status" class="form-control" rows="2"></textarea>
                    @if($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                    @endif

                </div>
                <button type="submit" class="btn btn-default">Update status</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            @if(!$statuses->count())
                <p>There are no statuses in your timeline</p>
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
                                @endif
                                    <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
                            </ul>
                        </div>
                        @foreach ($status->replies as $reply)
                            <div class="media">
                                <a class="pull-left" href=" {{ route('profile.index', ['username' => $reply->user->username]) }}"> <img class="media-object"
                                            alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->getAvatarUrl() }}"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h4>
                                    <p>{{ $reply->body }}</p>
                                    <ul class="list-inline">
                                        <li>{{ $reply->created_at->diffForHumans() }}</li>
                                        @if($reply->user->id !== Auth::user()->id)
                                            <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
                                        @endif
                                            <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <form role="form" action="{{ route('status.replay', ['statusId' => $status->id]) }}" method="post">
                            <div class="form-group {{ $errors->has("replay-{$status->id}")? ' has-error' : '' }}">
                                <textarea name="replay-{{ $status->id }}" class="form-control" rows="2" placeholder="replay..."></textarea>
                                @if($errors->has("replay-{$status->id}"))
                                    <span class="help-block">{{ $errors->first("replay-{$status->id}") }}</span>
                                @endif
                            </div>
                            <input type="submit" value="Replay" class="btn btn-default btn-small"> <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>



                @endforeach
                {{ $statuses->render() }}
            @endif
        </div>
    </div>
@stop