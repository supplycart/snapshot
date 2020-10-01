<?php

namespace Supplycart\Snapshot\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Supplycart\Snapshot\Tests\Stubs\User;
use Supplycart\Snapshot\Tests\TestCase;

class CaptureSnapshotTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::stub();
    }

    public function test_can_save_model_snapshot()
    {
        $this->user->takeSnapshot();

        $this->assertTrue($this->user->snapshots()->exists());

        $this->assertDatabaseHas('snapshots', [
            'model_type' => User::class,
            'model_id' => $this->user->id,
        ]);
    }

    public function test_can_retrieve_latest_snapshot()
    {
        $snapshot = $this->user->takeSnapshot();
        $snapshot2 = $this->user->takeSnapshot();

        $this->assertEquals(2, $this->user->snapshots()->count());

        $latestSnapshot = $this->user->getLatestSnapshot();

        $this->assertTrue($snapshot2->is($latestSnapshot));
    }
}
