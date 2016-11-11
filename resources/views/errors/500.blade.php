@extends('layouts.error', ['title' => '500 error', 'logo' => 'jitterbug-logo-sad'])

@section('panel')
<div id="error-panel">
    <h4 title="{{get_class($exception->getPrevious())}}">An error has occurred</h4>
    <div style="margin-top: 1rem;">
      We’ll look into it. In the meantime, you could try refreshing your page. 
    </div>
    <hr style="width: 450px;">
</div>
@endsection
