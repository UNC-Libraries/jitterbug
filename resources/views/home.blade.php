@extends('layouts.master', ['title' => 'Home', 'section' => 'home'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in! {{ Auth::user() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
