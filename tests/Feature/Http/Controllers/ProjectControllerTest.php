<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\TimeEntry;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Http\TestCase;

class ProjectControllerTest extends TestCase
{
    //use RefreshDatabase;

    #[Test] public function it_can_display_the_project_index_page()
    {
        Project::factory()->count(3)->create();
        $response = $this->get(route('projects.index'));
        $response->assertStatus(200);
        $response->assertViewIs('projects.index');
        $response->assertViewHas('projects');
    }

    #[Test] public function it_can_display_the_create_project_form()
    {
        $response = $this->get(route('projects.create'));
        $response->assertStatus(200);
        $response->assertViewIs('projects.create');
    }

    #[Test] public function it_can_store_a_new_project()
    {
        $data = ['name' => 'New Project', 'description' => 'A description for the new project.'];
        $response = $this->post(route('projects.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
        $response->assertRedirect(route('projects.index'));
    }

    #[Test] public function it_can_show_a_specific_project()
    {
        $project = Project::factory()->create();
        $response = $this->get(route('projects.show', $project));
        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $response->assertViewHas('project');
    }

    #[Test] public function it_can_start_timing_for_a_project()
    {
        $project = Project::factory()->create();
        $data = ['note' => 'Start time for the project'];
        $response = $this->post(route('projects.startTiming', $project), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('time_entries', ['project_id' => $project->id, 'note' => 'Start time for the project', 'start_time' => now()->format('Y-m-d H:i:s')]);
        $response->assertRedirect(route('projects.show', $project));
    }

    #[Test] public function it_can_stop_timing_for_a_project()
    {
        $project = Project::factory()->create();
        $timeEntry = TimeEntry::create(['project_id' => $project->id, 'start_time' => now(), 'note' => 'Start time for the project']);
        $response = $this->post(route('projects.stopTiming', $project));
        $response->assertStatus(302);
        $timeEntry->refresh();
        $this->assertNotNull($timeEntry->end_time);
        $response->assertRedirect(route('projects.show', $project));
        $this->assertNotNull($timeEntry->duration);
    }
}
