<?php

namespace Supplycart\Snapshot\Events;

use Illuminate\Queue\SerializesModels;
use Supplycart\Snapshot\Snapshot;

class SnapshotUpdated
{
    use SerializesModels;

    /**
     * @var \Supplycart\Snapshot\Snapshot
     */
    public $snapshot;

    /**
     * SnapshotCreated constructor.
     * @param \Supplycart\Snapshot\Snapshot $snapshot
     */
    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;
    }
}