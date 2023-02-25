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
        <br>
        <br>
        {!! Form::open(['route' => ['game.stop', $current_game->id], 'method' => 'post']) !!}
        {!! Form::submit('Удалить теущую игру', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @endif
@endsection
