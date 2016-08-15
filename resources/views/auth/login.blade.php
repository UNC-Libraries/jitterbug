@extends('layouts.auth', ['title' => 'Sign In', 'section' => 'auth'])

@section('panel')
<div id="sign-in-panel">
  <h4>Good Morning!</h4>
  <form role="form" method="post" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div style="margin-top: 2rem">
      <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-fw fa-user" aria-hidden="true"></i>
        </div>
        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Onyen">
      </div>
    </div>
    <div style="margin-top: .75rem">
      <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
        </div>
        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
      </div>
      <div style="margin-top: 1.5rem; margin-bottom: 1.5rem">
        <button type="submit" class="btn btn-primary btn-block" style="border: none">Sign In</button>
      </div>
    </div>
  </form>
</div>
@endsection
