@extends('layout.layout')


@section('content')
    <h1>Статистика по раундам</h1>

    @foreach($game->rounds as $round)
        @include('round.table', ['round' => $round])
    @endforeach
    <br>

    <h1>Статистика по игре</h1>

    <table border="1" class="table-striped">
        <thead>
        <th>Игрок</th>
        <th>Правильно ответил</th>
        <th>Всего вопросов</th>
        <th>Заработал денег</th>
        <th>Коэффициент правильности</th>
        <th>Раундов</th>>
        </thead>
        @foreach($game->getStatistics() as $user)
            <tr>
                <td>{{$user['name']. ( $user['id'] == $round->users()->where('strong', true)->first()->id ? ' (сильное звено) '  : ($user['id'] == $round->users()->where('weak', true)->first()->id ? '(слабое звено)' : ''))}}</td>
                <td>{{$user['right_answers']}}</td>
                <td>{{$user['answers']}}</td>
                <td>{{$user['money']}}</td>
                <td>{{$user['coefficient']}} %</td>
                <td>{{$user['rounds']}}</td>
            </tr>
        @endforeach
    </table>
@endsection
