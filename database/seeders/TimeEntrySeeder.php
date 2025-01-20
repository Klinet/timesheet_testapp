<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeEntry;

class TimeEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeEntry::factory()->count(5)->create();
    }
}
