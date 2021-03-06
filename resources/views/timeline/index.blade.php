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
                        <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                            <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href='{{ route('profile.index', ['username' => $status->user->username]) }}'>
                                    {{ $status->user->getNameOrUsername() }}</a></h4>
                            <p> {{ $status->body }} </p>
                            <ul class="list-inline">
                                <li>{{  $status->created_at->diffForHumans() }}</li>
                                <li><a href="#">Like</a></li>
                                <li>10 Likes</li>
                            </ul>
                        </div>
                        {{--<div class="media">--}}
                            {{--<a class="pull-left" href="#">--}}
                                {{--<img class="media-object" alt="" src="">--}}
                            {{--</a>--}}
                            {{--<div class="media-body">--}}
                                {{--<h4 class="media-heading"><a>Yariv</a></h4>--}}
                                {{--<p>Its lovely day today</p>--}}
                                {{--<ul class="list-inline">--}}
                                    {{--<li>8 minutes ago</li>--}}
                                    {{--<li><a href="#">Like</a></li>--}}
                                    {{--<li>4 Likes</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <textarea  name="reply-1" class="form-control"rows="2" placeholder="replay...">
                                </textarea>
                            </div>
                            <input type="submit" value="replay" class="btn btn-default btn-small">
                        </form>
                    </div>



                @endforeach
                {{ $statuses->render() }}
            @endif
        </div>
    </div>
@stop