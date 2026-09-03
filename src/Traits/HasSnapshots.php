<?php

declare(strict_types=1);

namespace Supplycart\Snapshot\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Supplycart\Snapshot\Events\SnapshotRestored;
use Supplycart\Snapshot\Snapshot;

trait HasSnapshots
{
    /**
     * Snapshot relationship
     */
    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'model');
    }

    /**
     * Take current model state snapshot
     */
    public function takeSnapshot(): Snapshot
    {
        /** @var Snapshot $snapshot */
        $snapshot = $this->snapshots()->create([
            'state' => $this->getSnapshotData(),
        ]);

        // cache latest snapshot
        Cache::put($this->snapshotCacheKey(), $snapshot);

        return $snapshot;
    }

    public function restoreSnapshot(Snapshot $snapshot): bool
    {
        $restored = $this->fill($snapshot->state)->save();

        if ($restored) {
            SnapshotRestored::dispatch($snapshot);
        }

        return $restored;
    }

    /**
     * Get latest snapshot
     */
    public function getLatestSnapshot(): ?Snapshot
    {
        return Cache::rememberForever($this->snapshotCacheKey(), function () {
            return $this->snapshots()->latest('id')->first();
        });
    }

    public function snapshotCacheKey(): string
    {
        return sprintf(
            'snapshot:%s:%s:latest',
            $this->getMorphClass(),
            $this->getKey(),
        );
    }

    /**
     * Get data to be saved as snapshot
     */
    public function getSnapshotData(): array
    {
        return $this->toArray();
    }
}
