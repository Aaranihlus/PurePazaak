@extends('sections.layout')

@section('content')

<h1>Games</h1>

@foreach($games as $game)

  {{ $game }}

@endforeach

@endsection('content')
