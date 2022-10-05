@extends('layout.layout')

@section('content')
    <h1>Игроки</h1>

    <a href="{{route('users.create')}}">
        <button class="btn btn-primary">Создать</button>
    </a>
    <table class="table">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Активный</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>@if ($user->is_active) Да @else Нет @endif</td>
                <td><a href="{{route('users.edit', ['user' => $user])}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                </td>
                <td>
                    {!! Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', ['user' => $user]]]) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
