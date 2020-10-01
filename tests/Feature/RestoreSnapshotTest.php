<?php

namespace Supplycart\Snapshot\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Supplycart\Snapshot\Tests\Stubs\User;
use Supplycart\Snapshot\Tests\TestCase;

class RestoreSnapshotTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::stub();
    }

    public function test_can_restore_snapshot()
    {
        $oldName = $this->user->name;
        $snapshot = $this->user->takeSnapshot();

        $this->user->update(['name' => 'Updated Name']);

        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
        $this->assertEquals('Updated Name', $this->user->refresh()->name);

        $this->user->restoreSnapshot($snapshot);

        $this->assertDatabaseHas('users', ['name' => $oldName]);
        $this->assertEquals($oldName, $this->user->name);
    }
}
