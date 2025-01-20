@extends('layouts.app')

@section('content')
    <h1>Projektek</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Siker!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if ($projects->isEmpty())
        <div class="container mx-auto px-4 mt-6">
            <h1 class="text-2xl font-bold mb-4">Nincsenek projektek rögzítve</h1>
            <p class="text-gray-600">Jelenleg nincsenek projektek rögzítve az adatbázisban.</p>
        </div>
        <div class="container mx-auto px-4 mt-6">
            <a href="{{ route('projects.create') }}" class="mt-10 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Új projekt hozzáadása</a>
        </div>
    @else
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Név</th>
                <th class="px-4 py-2">Leírás</th>
                <th class="px-4 py-2">Műveletek</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td class="border px-4 py-2">{{ $project->name }}</td>
                    <td class="border px-4 py-2">{{ $project->description }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline">Megtekintés</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $projects->links() }}
    @endif
@endsection
