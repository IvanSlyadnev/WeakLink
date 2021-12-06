@extends('layout.layout')

@section('content')

    <h1>Вопросы</h1>

    <a href="{{route('question.create')}}">
        <button class="btn btn-primary">Создать</button>
    </a>
    <table class="table">
        <thead>
        <tr>
            <th>Вопрос</th>
            <th>Ответ</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{$question->text}}</td>
                <td>{{$question->answer}}</td>
                <td><a href="{{route('question.edit', ['question' => $question])}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                </td>
                <td>
                    {!! Form::model($question, ['method' => 'delete', 'route' => ['question.destroy', ['question' => $question]]]) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
