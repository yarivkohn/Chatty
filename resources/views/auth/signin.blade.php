@extends('templates.default')

@section('content')
    <div class="container">
        <div class="row">
            <h3 class="text-center">Sign in</h3>
            <div class="col-lg-6 col-lg-offset-3">
                <form class="form-vertical" role="form" action="{{ route('auth.signin') }}" method="post">
                    <div class="form-group {{ ($errors->has('email'))? ' has-error' : '' }}">
                        <label for="email" class="control-label">Your Email address</label>
                        <input type="email" name="email" value="{{Request::old('email')?: ''}}"
                               id="email" placeholder="user@service.com" class="form-control">
                        @if ($errors->has('email'))
                            <span class="help-block"> {{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('password')? ' has-error' : '' }}">
                        <label for="password" class="control-label">Choose Password</label>
                        <input type="password" name="password"
                               id="password" class="form-control">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember">Remember me
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>
    </div>
@stop
