<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;
    
    private User $user;
    private TaskStatus $taskStatus;
    private string $taskStatusUpdate;

    public function setUp(): void
    {
        parent::SetUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->taskStatusUpdate = TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('task_statuses.store'), [
                'name' => $this->taskStatus
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => $this->taskStatus]);
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testEdit(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.edit', ['task_status' => $this->taskStatus]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch(route('task_statuses.update', ['task_status' => $this->taskStatus]), [
                'name' => $this->taskStatusUpdate
            ]);
        
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => $this->taskStatusUpdate]);
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testDestroy(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus]));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
        $response->assertRedirect(route('task_statuses.index'));
    }

    public function testStoreNotAuth(): void
    {
        $response = $this
            ->post(route('task_statuses.store'), [
                'name' => $this->taskStatus
            ]);

        $response->assertStatus(403);
    }

    public function testUpdateNotAuth(): void
    {
        $response = $this
            ->patch(route('task_statuses.update', ['task_status' => $this->taskStatus]), [
                'name' => $this->taskStatusUpdate
        ]);

        $response->assertStatus(403);
    }

    public function testDestroyNotAuth(): void
    {
        $response = $this
            ->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus]));

        $response->assertStatus(403);
    }
}
