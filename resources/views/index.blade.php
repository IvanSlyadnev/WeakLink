@extends('layout.layout')

@section('content')

    <h1>Игры</h1>

    <a href="{{route('game.start')}}">
        <button class="btn btn-primary">Начать игру</button>
    </a>
@endsection
