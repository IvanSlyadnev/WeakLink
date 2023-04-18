@extends('layout.layout')

@section('content')
    <h1>Банк игры - {{$game->bank}}</h1>
    <br>
    Раунд - {{$round->number}}
    <br>
    Банк раунда - {{$round->bank}}
    <br>
    Текущий счет - {{$round->current_money}}
    <br>
    Игрок - {{$round->current_user->name}}
    <br>
    Вопрос - {{$round->current_question->text}}
    <br>
    Ответ - {{$round->current_question->answer}}
    <br>
    <a href="{{route('question.control', ['result' => 1, 'round' => $round->id])}}">
        <button class="btn btn-outline-success">Верно</button>
    </a>

    <a href="{{route('question.control', ['result' => 0, 'round' => $round->id])}}">
        <button class="btn btn-outline-danger">Не верно</button>
    </a>

    <br>
    <br>
    <a href="{{route('round.bank', ['round' => $round->id])}}">
        <button class="btn btn-outline-primary">Банк!!!</button>
    </a>

    <br>
    <br>
    <a href="{{route('round.stop', ['round' => $round->id])}}" data-confirm="Are you sure to delete this item?">
        <button class="btn btn-outline-success">Завершить раунд</button>
    </a>
@endsection
