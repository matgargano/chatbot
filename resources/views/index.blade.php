@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Support site</h1>
                <div id="cookie-setter">
                    <cookie-setter></cookie-setter>
                </div>
            </div>
        </div>
    </div>
    <div id="chat" class="chat">
        <chat></chat>
    </div>
@endsection