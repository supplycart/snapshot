<?php

namespace Supplycart\Snapshot\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Supplycart\Snapshot\Snapshot;

interface HasSnapshots
{
    public function snapshots(): MorphMany;

    public function takeSnapshot(): Snapshot;

    public function getLastSnapshot(): Snapshot;

    public function getSnapshotData(): array;
}