@extends('layouts.app')

@section('title', 'Projekt Részletei')

@section('content')
    @php
        use Carbon\Carbon;
        $totalSeconds = $project->timeEntries->sum(function ($entry) {
            return timeToSeconds($entry->duration);
        });
        $totalDuration = secondsToTime($totalSeconds);
    @endphp
    <div x-data="{ showModal: false, timingStarted: false, currentEntry: {} }" class="container mx-auto px-4 mt-6">
        <h1 class="text-2xl font-bold mb-4"></h1>
        <p class="text-gray-600 mb-4">{{ $project->description }}</p>
        <div x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add Note and Start Timing</h3>
                        <div class="mt-2">
                            <form action="{{ route('projects.startTiming', $project->id) }}" method="POST"
                                  @submit="timingStarted = true; currentEntry = { start_time: '{{ now() }}', end_time: null, duration: null, note: $event.target.note.value }">
                                @csrf
                                <div class="mb-4">
                                    <label for="note" class="block text-gray-700 text-sm font-bold mb-2">Note:</label>
                                    <input type="text" name="note" id="note"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           required>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="button" @click="showModal = false"
                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                            @click="showModal = false">
                                        Start
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header">
            <h1>Project: {{ $project->name }}</h1>
            <p>Created at: {{ $project->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
        <div class="summary">
            <table class="projects total">
                <tr>
                    <th>Note</th>
                    <th>Duration</th>
                </tr>
                @php
                    $totalDurationInSeconds = 0;
                @endphp
                @foreach ($project->timeEntries as $timeEntry)
                    @php
                        $durationInSeconds = Carbon::parse($timeEntry->start_time)->diff(Carbon::parse($timeEntry->end_time))->s;
                        $totalDurationInSeconds += $durationInSeconds;
                    @endphp
                    <tr>
                        <td>{{ $timeEntry->note }}</td>
                        <td>{{ gmdate('H:i:s', $durationInSeconds) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ gmdate('H:i:s', $totalDurationInSeconds) }}</strong></td>
                </tr>
            </table>
        </div>
        <h2 class="text-xl font-bold mb-2">Időkövetési Bejegyzések</h2>
        <button @click="showModal = true"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4">Timing
        </button>
        @if ($project->timeEntries->isEmpty())
            <p class="text-gray-600">Nincsenek időkövetési bejegyzések ehhez a projekthez.</p>
        @else
            <table class="projects min-w-full bg-white shadow-md rounded-lg overflow-hidden my-20">
                <thead class="bg-gray-200">
                <tr>
                    <th>Project</th>
                    <th>Start</th>
                    <th>Finish</th>
                    <th>Duration</th>
                    <th>Memo</th>
                </tr>
                </thead>
                @foreach ($project->timeEntries as $timeEntry)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $timeEntry->start_time }}</td>
                        <td>{{ $timeEntry->end_time }}</td>
                        <td>{{ gmdate('H:i:s', Carbon::parse($timeEntry->start_time)->diff(Carbon::parse($timeEntry->end_time))->s) }}</td>
                        <td>{{ $timeEntry->note }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="mt-4">
            <a href="{{ route('projects.index') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Vissza a Projektekhez</a>
        </div>
    </div>
@endsection
