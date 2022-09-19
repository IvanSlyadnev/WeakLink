@extends('layout.layout')

@section('content')

    <div class="container">
        <div class="row">
            <h1>ФИНАЛ</h1>
            <h2>Проведите финал. Выберете кто победил</h2>
            {!! Form::open(['route' => route('game.stop'), 'method' => 'post']) !!}
            {!! Form::select('') !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection
