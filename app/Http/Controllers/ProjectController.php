<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TimeEntry;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('timeEntries')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'description' => 'nullable|string',
        ]);

        $project = new Project();
        $project->name = $request->name;
        //$project->description = $request->description;
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen létrehozva.');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $project = Project::with('timeEntries')->findOrFail($id);
        $totalDurationInSeconds = 0;
        foreach ($project->timeEntries as $timeEntry) {
            $startTime = Carbon::parse($timeEntry->start_time);
            $endTime = Carbon::parse($timeEntry->end_time);
            $durationInSeconds = $endTime->diffInSeconds($startTime);
            $totalDurationInSeconds += $durationInSeconds;
        }
        $totalDuration = gmdate('H:i:s', $totalDurationInSeconds);
        return view('projects.show', compact('project', 'totalDuration'));
    }



    private function secondsToTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Start the timing.
     */
    public function startTiming(Request $request, Project $project)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $timeEntry = new TimeEntry();
        $timeEntry->project_id = $project->id;
        $timeEntry->start_time = Carbon::now();
        $timeEntry->note = $request->note;
        $timeEntry->save();

        return redirect()->route('projects.show', $project->id)->with('success', 'Időzítés elindult.');
    }


    /**
     * Stop the timing.
     */
    public function stopTiming(Project $project)
    {
        $timeEntry = TimeEntry::where('project_id', $project->id)
            ->whereNull('end_time')
            ->latest()
            ->first();

        if ($timeEntry) {
            $timeEntry->end_time = Carbon::now();
            $start_time = Carbon::parse($timeEntry->start_time);
            $end_time = Carbon::parse($timeEntry->end_time);
            $duration = $end_time->diffInSeconds($start_time); // calculate duration in seconds
            $timeEntry->duration = $duration; // save duration in seconds
            $timeEntry->save();
        }

        return redirect()->route('projects.show', $project->id)->with('success', 'Időzítés leállt.');
    }
}
