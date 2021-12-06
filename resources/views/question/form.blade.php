@extends('layout.layout')

@section('content')
    @if ($question->id)
        {!! Form::model($question, ['method' => 'put', 'route' => ['question.update', $question->id]]) !!}
    @else
        {!! Form::model($question, ['method' => 'post', 'route' => ['question.store']]) !!}
    @endif

    {!! Form::label('text'.$question->id, 'Введите вопрос') !!}
    {!! Form::text('text', $question->id ? $question->text : null, ['class' => 'form-control']) !!}
    {!! Form::label('answer'.$question->id, 'Введите ответ') !!}
    {!! Form::text('answer', $question->id ? $question->answer : null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::submit($question->id ? 'Редактировать' : 'Создать', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@endsection
