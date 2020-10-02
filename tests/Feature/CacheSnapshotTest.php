<?php

namespace Supplycart\Snapshot\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Supplycart\Snapshot\Tests\Stubs\User;
use Supplycart\Snapshot\Tests\TestCase;

class CacheSnapshotTest extends TestCase
{
    use RefreshDatabase;

    public function test_snapshot_is_cached()
    {
        $user = User::stub();
        $snapshot = $user->takeSnapshot();

        $this->assertEquals($snapshot, Cache::get("snapshot:{$user->getKey()}:latest"));
    }
}
