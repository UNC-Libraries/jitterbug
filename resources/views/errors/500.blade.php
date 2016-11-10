@extends('layouts.error', ['title' => '500 error', 'logo' => 'jitterbug-logo-sad'])

@section('panel')
<div id="error-panel">
    <h4>An error has occurred</h4>
    <div style="margin-top: 1rem;">
      <span title="{{get_class($exception)}}">We’ll look into it.</span> In the meantime, you could try refreshing your page. 
    </div>
    <hr style="width: 320px;">
</div>
@endsection
