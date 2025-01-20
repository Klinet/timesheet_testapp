<?php

namespace Database\Factories;

use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeEntryFactory extends Factory
{
    protected $model = TimeEntry::class;

    public function definition()
    {
        $startTime = Carbon::createFromFormat('H:i:s', $this->faker->time());
        $endTime = $startTime->copy()->addHour();
        $duration = $startTime->diff($endTime)->format('%H:%I:%S');

        return [
            'project_id' => \App\Models\Project::factory(),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'duration' => $duration,
            'note' => $this->faker->sentence,
        ];
    }
}
