<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $secondUser;
    private Task $task;
    private array $newTask;
    private array $taskUpdate;

    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->secondUser = User::factory()->make();
        $this->task = Task::factory()->make([
            'created_by_id' => $this->user->id,
        ]);

        $this->newTask = Task::factory()->make()->only([
            'name',
            'description',
            'status_id',
            'assigned_to_id'
        ]);

        $this->taskUpdate = Task::factory()->make()->only([
            'name',
            'description',
            'status_id',
            'assigned_to_id'
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('tasks.store'), $this->newTask);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $this->newTask);
        $response->assertRedirect(route('tasks.index'));
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertOk();
        $response->assertSee($this->task->name);
    }

    public function testEdit(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.edit', ['task' => $this->task]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch(route('tasks.update', ['task' => $this->task]), $this->taskUpdate);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $this->taskUpdate);
        $response->assertRedirect(route('tasks.index'));
    }

    public function testDestroy(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('tasks.destroy', ['task' => $this->task]));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
        $response->assertRedirect(route('tasks.index'));
    }

    public function testStoreNotAuth(): void
    {
        $response = $this
            ->get(route('tasks.edit', ['task' => $this->task]));

        $response->assertStatus(403);
    }

    public function testUpdateNotAuth(): void
    {
        $response = $this
            ->patch(route('tasks.update', ['task' => $this->task]), $this->taskUpdate);

        $response->assertStatus(403);
    }

    public function testDestroyNotCreator(): void
    {
        $response = $this
            ->actingAs($this->secondUser)
            ->delete(route('tasks.destroy', ['task' => $this->task]));

        $response->assertStatus(403);
    }
}
