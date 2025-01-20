@extends('layouts.app')

@section('title', 'Oldal nem található')

@section('content')
    <div class="container">
        <h1 class="display-4">404 - Oldal nem található</h1>
        <p class="lead">Sajnáljuk, de az általad keresett oldal nem található.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Vissza a főoldalra</a>
    </div>
@endsection

