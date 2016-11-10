@extends('layouts.error', ['title' => '404 error', 'logo' => 'jitterbug-logo-surprised'])

@section('panel')
<div id="error-panel">
    <h4>Page not found</h4>
    <div style="margin-top: 1rem;">
      Sorry, but the page you requested was not found.
    </div>
    <hr style="width: 320px;">
</div>
@endsection
