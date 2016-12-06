@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <div id="cookie-setter">
                <cookie-setter></cookie-setter>
            </div>
        </div>
    </div>
    <div id="chat" class="chat">
        <chat></chat>
    </div>
@endsection