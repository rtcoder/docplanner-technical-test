<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)->get('/api/tasks');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/tasks', [
                'title' => 'New Task',
                'content' => 'Task content',
                'user_id' => $this->user->id,
                'status' => 1,
            ]);

        $response->assertStatus(201);
    }

    public function testShow()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->get("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson($task->toArray());
    }

    public function testUpdate()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->putJson("/api/tasks/{$task->id}", [
                'title' => 'Updated Task',
                'content' => 'Updated content',
                'user_id' => $this->user->id,
                'status' => 2,
            ]);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete("/api/tasks/{$task->id}");

        $response->assertStatus(204);
    }
}
