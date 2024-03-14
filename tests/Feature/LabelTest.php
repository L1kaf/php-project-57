<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Label $label;
    private string $updateLabel;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        /** @var Label $labelInstance */
        $labelInstance = Label::factory()->create();
        $this->label = $labelInstance;
        /** @var Label $labelUpdateInstance */
        $labelUpdateInstance = Label::factory()->create();
        $this->updateLabel = $labelUpdateInstance;
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('labels.store'), [
                'name' => $this->label
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => $this->label]);
        $response->assertRedirect(route('labels.index'));
    }

    public function testEdit(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('labels.edit', ['label' => $this->label]));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch(route('labels.update', ['label' => $this->label]), [
                'name' => $this->updateLabel
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => $this->updateLabel]);
        $response->assertRedirect(route('labels.index'));
    }

    public function testDestroy(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('labels.destroy', ['label' => $this->label]));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
        $response->assertRedirect(route('labels.index'));
    }

    public function testStoreNotAuth(): void
    {
        $response = $this
            ->post(route('labels.store'), [
                'name' => $this->label
            ]);

        $response->assertStatus(403);
    }

    public function testUpdateNotAuth(): void
    {
        $response = $this
            ->patch(route('labels.update', ['label' => $this->label]), [
                'name' => $this->updateLabel
            ]);

        $response->assertStatus(403);
    }

    public function testDestroyNotAuth(): void
    {
        $response = $this
            ->delete(route('labels.destroy', ['label' => $this->label]));

        $response->assertStatus(403);
    }
}
