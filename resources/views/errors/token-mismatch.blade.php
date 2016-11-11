@extends('layouts.error', ['title' => 'Form Expired', 'logo' => 'jitterbug-logo-surprised'])

@section('panel')
<div id="error-panel">
    <h4>Your form has expired</h4>
    <div style="margin-top: 1rem;">
      Please refresh the page and try submitting your form again.
    </div>
    <hr style="width: 380px;">
</div>
@endsection
