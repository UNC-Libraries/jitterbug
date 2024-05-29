@extends('layouts.auth', ['title' => 'Sign In', 'section' => 'auth'])

@section('panel')
<div id="sign-in-panel">
  @if (app('request')->input('logout')==='true')
    <h4 id='farewell'>See you next time!</h4>
  @else
    <h4 id='greeting'></h4>
  @endif
  {{ html()->form('POST', url('/login'))->open() }}
    <div style="margin-top: 2rem">
      @if ($errors->has('failedLogin'))
      <div class="failed-login">
        {!! $errors->first('failedLogin') !!}
      </div>
      @endif
      <div class="input-group @if ($errors->has('username')) has-danger @endif">
        <div class="input-group-addon">
          <i class="fa fa-fw fa-user" aria-hidden="true"></i>
        </div>
        {{ html()->text('username')->class('form-control')->placeholder('Onyen') }}
      </div>
    </div>
    <div style="margin-top: .75rem">
      <div class="input-group @if ($errors->has('password')) has-danger @endif">
        <div class="input-group-addon">
          <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
        </div>
        {{ html()->password('password')->class('form-control')->attribute('placeholder', 'Password') }}
      </div>
      <div style="margin-top: 1.5rem; margin-bottom: 1.5rem">
        <button type="submit" class="btn btn-primary btn-block" style="border: none">Sign In</button>
      </div>
    </div>
  {{ html()->form()->close() }}
</div>
@endsection
