@extends('templates.default')

@section('content')
        <h3 class="text-center">Sign up</h3>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <form class="form-vertical" role="form" action="{{ route('auth.signup') }}" method="post">
                    <div class="form-group {{$errors->has('email')? ' has-error':''}}">
                        <label for="email" class="control-label">Your Email address</label>
                        <input type="email" name="email" value="{{Request::old('email')?: ''}}"
                               id="email" placeholder="user@service.com" class="form-control">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('username')? ' has-error':''}}">
                        <label for="username" class="control-label">Choose Username</label>
                        <input type="text" name="username" value="{{Request::old('username')?:''}}"
                               id="username" placeholder="JohnDoe" class="form-control">
                        @if ($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('password')? ' has-error':''}}">
                        <label for="password" class="control-label">Choose Password</label>
                        <input type="password" name="password"
                               id="password" class="form-control">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Sign up</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>
@stop
