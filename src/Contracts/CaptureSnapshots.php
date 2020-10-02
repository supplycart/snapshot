<?php

namespace Supplycart\Snapshot\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Supplycart\Snapshot\Snapshot;

interface CaptureSnapshots
{
    public function snapshots(): MorphMany;

    public function takeSnapshot(): Snapshot;

    public function restoreSnapshot(Snapshot $snapshot): bool;

    public function getLatestSnapshot(): ?Snapshot;

    public function getSnapshotData(): array;
}