@extends('layout.layout')

@section('content')
    @if ($user->id)
        {!! Form::model($user, ['method' => 'put', 'route' => ['user.update', $user->id]]) !!}
    @else
        {!! Form::model($user, ['method' => 'post', 'route' => ['users.store']]) !!}
    @endif

    {!! Form::label('name'.$user->id, 'Введите имя') !!}
    {!! Form::text('name', $user->id ? $user->name : null, ['class' => 'form-control']) !!}
    {!! Form::label('name'.$user->id, 'активный') !!}
    {!! Form::checkbox('is_active', 1, true) !!}
    <br>
    {!! Form::submit($user->id ? 'Редактировать' : 'Создать', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@endsection
