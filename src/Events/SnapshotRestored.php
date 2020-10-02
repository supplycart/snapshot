<?php

namespace Supplycart\Snapshot\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Supplycart\Snapshot\Snapshot;

class SnapshotRestored
{
    use Dispatchable, SerializesModels;

    /**
     * @var \Supplycart\Snapshot\Snapshot
     */
    public Snapshot $snapshot;

    /**
     * SnapshotCreated constructor.
     * @param \Supplycart\Snapshot\Snapshot $snapshot
     */
    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;
    }
}