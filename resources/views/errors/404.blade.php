@extends('layouts.error', ['title' => '404 error', 'logo' => 'jitterbug-logo-surprised'])

@section('panel')
<div id="error-panel">
    <h4>Resource not found</h4>
    <div style="margin-top: 1rem;">
      Sorry, but the resource you requested was not found.
    </div>
    <hr style="width: 340px;">
</div>
@endsection
