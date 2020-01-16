<?php

namespace Supplycart\Snapshot\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Supplycart\Snapshot\Snapshot;

trait HasSnapshots
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'model');
    }

    /**
     * @return Snapshot
     */
    public function takeSnapshot(): Snapshot
    {
        return $this->snapshots()->create([
            'state' => $this->getSnapshotData(),
        ]);
    }

    /**
     * @return Snapshot
     */
    public function getLatestSnapshot(): Snapshot
    {
        return $this->snapshots()->latest('id')->first();
    }

    public function getSnapshotData(): array
    {
        return $this->toArray();
    }
}