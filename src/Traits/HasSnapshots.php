<?php

namespace Supplycart\Snapshot\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Supplycart\Snapshot\Events\SnapshotRestored;
use Supplycart\Snapshot\Snapshot;

trait HasSnapshots
{
    /**
     * Snapshot relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'model');
    }

    /**
     * Take current model state snapshot
     *
     * @return Snapshot
     */
    public function takeSnapshot(): Snapshot
    {
        return $this->snapshots()->create([
            'state' => $this->getSnapshotData(),
        ]);
    }

    public function restoreSnapshot(Snapshot $snapshot): bool
    {
        $restored  = $this->fill($snapshot->state)->save();

        if ($restored) {
            SnapshotRestored::dispatch($snapshot);
        }

        return $restored;
    }

    /**
     * Get latest snapshot
     *
     * @return Snapshot
     */
    public function getLatestSnapshot(): Snapshot
    {
        return $this->snapshots()->latest('id')->first();
    }

    /**
     * Get data to be saved as snapshot
     *
     * @return array
     */
    public function getSnapshotData(): array
    {
        return $this->toArray();
    }
}