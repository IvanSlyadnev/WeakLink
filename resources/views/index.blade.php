@extends('layout.layout')

@section('content')

    <h1>Игры</h1>

    @if (!$current_game)
        <a href="{{route('game.start')}}">
            <button class="btn btn-primary">Начать игру</button>
        </a>
    @else
        <a href="{{route('game.continue', ['game' => $current_game->id])}}}">
            <button class="btn btn-primary">Продолжить игру</button>
        </a>
    @endif
@endsection
