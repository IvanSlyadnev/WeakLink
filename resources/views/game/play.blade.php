@extends('layout.layout')

@section('content')
    Банк игры - {{$game->bank}}
    <br>
    Раунд - {{$round->number}}
    <br>
    Банк - {{$round->bank}}
    <br>
    Текущий счет - {{$round->current_money}}
    <br>
    Игрок - {{$round->current_user->name}}
    <br>
    Вопрос - {{$round->current_question->text}}
    Ответ - {{$round->current_question->answer}}
    <a href="{{route('question.control', ['result' => 1, 'round' => $round->id])}}">
        <button class="btn btn-success">Верно</button>
    </a>

    <a href="{{route('question.control', ['result' => 0, 'round' => $round->id])}}">
        <button class="btn btn-danger">Не верно</button>
    </a>

    <br>
    <a href="{{route('round.bank', ['round' => $round->id])}}">
        <button class="btn btn-primary">Банк!!!</button>
    </a>

    <br>
    <a href="{{route('round.stop', ['round' => $round->id])}}">
        <button class="btn btn-success">Завершить раунд</button>
    </a>
@endsection
