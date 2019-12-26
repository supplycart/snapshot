<?php

namespace Supplycart\Snapshot\Traits;

use Supplycart\Snapshot\Snapshot;

trait HasSnapshots
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function snapshots()
    {
        return $this->morphMany(Snapshot::class, 'model');
    }

    /**
     * @return Snapshot
     */
    public function takeSnapshot()
    {
        return $this->snapshots()->create([
            'snapshot' => $this->snapshotData(),
        ]);
    }

    /**
     * @return Snapshot
     */
    public function getLastSnapshot()
    {
        return $this->snapshots()->latest()->first();
    }
}