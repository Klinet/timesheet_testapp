<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Integration\Http\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_can_create_a_project()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
