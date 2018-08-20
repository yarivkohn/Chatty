@extends('templates.default')

@section('content')
    <div class="row">
        <h3 class="text-center">Edit profile data</h3>
        <div class="col-lg-6 col-lg-offset-3">
            <form class="form-vertical" role="form" action="{{ route('profile.edit') }}" method="post">
                <div class="form-group {{$errors->has('first_name')? ' has-error':''}}">
                    <label for="first_name" class="control-label">First name</label>
                    <input type="text" name="first_name" value="{{Request::old('first_name')?: Auth::user()->first_name}}"
                           id="first_name" class="form-control">
                    @if ($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>

                <div class="form-group {{$errors->has('last_name')? ' has-error':''}}">
                    <label for="last_name" class="control-label">Last name</label>
                    <input type="text" name="last_name" value="{{ Request::old('last_name')?: Auth::user()->last_name}}"
                           id="lastname" class="form-control">
                    @if ($errors->has('last_name'))
                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>

                <div class="form-group {{$errors->has('location')? ' has-error':''}}">
                    <label for="location" class="control-label">Location</label>
                    <input type="text" name="location" value="{{ Request::old('location')?: Auth::user()->location}}"
                           id="location" class="form-control">
                    @if ($errors->has('location'))
                        <span class="help-block">{{ $errors->first('location') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">Update</button>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>
@stop
