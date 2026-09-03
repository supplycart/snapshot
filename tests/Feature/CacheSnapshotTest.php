<?php

declare(strict_types=1);

namespace Supplycart\Snapshot\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Supplycart\Snapshot\Tests\Stubs\User;
use Supplycart\Snapshot\Tests\TestCase;

final class AlternateUser extends User
{
    protected $table = 'users';
}

class CacheSnapshotTest extends TestCase
{
    use RefreshDatabase;

    public function test_snapshot_is_cached(): void
    {
        $user = User::stub();
        $snapshot = $user->takeSnapshot();

        $this->assertEquals($snapshot, Cache::get($user->snapshotCacheKey()));
    }

    public function test_models_with_the_same_primary_key_do_not_share_the_latest_snapshot_cache(): void
    {
        $user = User::stub();
        $userSnapshot = $user->takeSnapshot();

        $alternateUser = AlternateUser::query()->findOrFail($user->getKey());
        $alternateSnapshot = $alternateUser->takeSnapshot();

        $this->assertNotSame($user->getMorphClass(), $alternateUser->getMorphClass());
        $this->assertTrue($userSnapshot->is($user->getLatestSnapshot()));
        $this->assertTrue($alternateSnapshot->is($alternateUser->getLatestSnapshot()));
    }
}
