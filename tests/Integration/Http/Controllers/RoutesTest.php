<?php

namespace Tests\Integration\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use Tests\Integration\Http\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_can_access_the_project_index_route()
    {
        $response = $this->get(route('projects.index'));
        $response->assertStatus(200);
    }

    #[Test] public function it_can_access_the_create_project_route()
    {
        $response = $this->get(route('projects.create'));
        $response->assertStatus(200);
    }

    #[Test] public function it_can_access_the_store_project_route()
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'A project to test the store functionality.',
        ];

        $response = $this->post(route('projects.store'), $data);
        $response->assertStatus(302);
    }

    #[Test] public function it_can_access_the_show_project_route()
    {
        $project = Project::factory()->create();
        $response = $this->get(route('projects.show', $project));
        $response->assertStatus(200);
    }
}
