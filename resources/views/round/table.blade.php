<h2>Раунд {{$round->number}}</h2>
<table border="1" class="table-striped">
    <thead>
    <th>Игрок</th>
    <th>Правильно ответил</th>
    <th>Всего вопросов</th>
    <th>Заработал денег</th>
    <th>Коэффициент правильности</th>
    @if(isset($select)) <th>Выбрать для уничтожения</th> @endif
    </thead>

    {!! Form::open(['route' => ['round.next', $round->id], 'method' => 'post']) !!}
    @foreach($round->setStrongLink() as $user)
        <tr>
            <td>{{$user['name']. ( $user['id'] == $round->users()->where('strong', true)->first()->id ? ' (сильное звено) '  : ($user['id'] == $round->users()->where('weak', true)->first()->id ? '(слабое звено)' : ''))}}</td>
            <td>{{$user['right_answers']}}</td>
            <td>{{$user['answers']}}</td>
            <td>{{$user['money']}}</td>
            <td>{{$user['coefficient']}} %</td>
            @if(isset($select)) <td>{{Form::radio('name', $user['id'])}}</td> @endif
        </tr>
    @endforeach
</table>
