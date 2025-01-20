@extends('layouts.app')

@section('title', 'Új Projekt Hozzáadása')

@section('content')
    <div class="container mx-auto px-4 mt-6">
        <h1 class="text-2xl font-bold mb-4">Új Projekt Hozzáadása</h1>
        <form action="{{ route('projects.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Név:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Hozzáadás
                </button>
            </div>
        </form>
    </div>
@endsection
