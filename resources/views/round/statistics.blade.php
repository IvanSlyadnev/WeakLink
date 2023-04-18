@extends('layout.layout')


@section('content')

    <h1>Раунд {{$round->number}} завершен</h1>

    <h2>Банк игры {{$round->game->bank}}</h2>

    <h2>Банк раунда {{$round->bank}}</h2>

    <h2>Сильное звено по статистике {{$strong->name}}</h2>

    <h2>Слабое звено по статистике {{$weak->name}}</h2>

    @include('round.table', ['round' => $round, 'select' => true])
    <br>
    {!! Form::submit('Следующий раунд', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
