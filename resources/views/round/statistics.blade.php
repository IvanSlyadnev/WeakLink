@extends('layout.layout')


@section('content')

    <h1>Раунд {{$round->number}} завершен</h1>

    <h2>Банк игры {{$round->game->bank}}</h2>

    <h2>Банк раунда {{$round->bank}}</h2>

    <h2>Сильное звено по статистике {{$strong->name}}</h2>

    <h2>Слабое звено по статистике {{$weak->name}}</h2>

    <table border="1" class="table-striped">
        <thead>
            <th>Игрок</th>
            <th>Правильно ответил</th>
            <th>Всего вопросов</th>
            <th>Заработал денег</th>
            <th>Коэффициент правильности</th>
            <th>Выбрать для уничтожения</th>
        </thead>

        {!! Form::open(['route' => ['round.next', $round->id], 'method' => 'post']) !!}
        @foreach($users as $user)
            <tr>
                <td>{{$user['name']. ( $user['id'] == $strong->id ? ' (сильное звено) '  : ($user['id'] == $weak->id ? '(слабое звено)' : ''))}}</td>
                <td>{{$user['right_answers']}}</td>
                <td>{{$user['answers']}}</td>
                <td>{{$user['money']}}</td>
                <td>{{$user['coefficient']}} %</td>
                <td>{{Form::radio('name', $user['id'])}}</td>
            </tr>
        @endforeach
    </table>
    {!! Form::submit('Следующий раунд', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
