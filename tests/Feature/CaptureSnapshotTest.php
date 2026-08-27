<?php

declare(strict_types=1);

namespace Supplycart\Snapshot\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Supplycart\Snapshot\Events\SnapshotCreated;
use Supplycart\Snapshot\Events\SnapshotUpdated;
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
        Event::fake([SnapshotCreated::class]);

        $this->user->takeSnapshot();

        $this->assertTrue($this->user->snapshots()->exists());

        $this->assertDatabaseHas('snapshots', [
            'model_type' => User::class,
            'model_id' => $this->user->id,
        ]);

        Event::assertDispatched(SnapshotCreated::class);
    }

    public function test_can_retrieve_latest_snapshot()
    {
        $snapshot = $this->user->takeSnapshot();
        $snapshot2 = $this->user->takeSnapshot();

        $this->assertEquals(2, $this->user->snapshots()->count());

        Cache::forget($this->user->snapshotCacheKey());
        $latestSnapshot = $this->user->getLatestSnapshot();

        $this->assertTrue($snapshot2->is($latestSnapshot));
    }

    public function test_snapshot_exposes_its_state_and_parent_model()
    {
        $snapshot = $this->user->takeSnapshot();

        $this->assertSame($this->user->getSnapshotData(), $snapshot->toArray());
        $this->assertTrue($this->user->is($snapshot->model));
    }

    public function test_updating_a_snapshot_dispatches_an_event()
    {
        $snapshot = $this->user->takeSnapshot();
        Event::fake([SnapshotUpdated::class]);

        $snapshot->update(['state' => ['name' => 'Changed']]);

        Event::assertDispatched(
            SnapshotUpdated::class,
            fn (SnapshotUpdated $event) => $event->snapshot->is($snapshot),
        );
    }

    public function test_latest_snapshot_is_null_before_one_is_created()
    {
        $this->assertNull($this->user->getLatestSnapshot());
    }
}
