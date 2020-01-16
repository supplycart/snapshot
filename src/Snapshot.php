<?php

namespace Supplycart\Snapshot;

use Illuminate\Database\Eloquent\Model;
use Supplycart\Snapshot\Events\SnapshotCreated;
use Supplycart\Snapshot\Events\SnapshotUpdated;

/**
 * Class Snapshot
 * @package Supplycart\Snapshot
 *
 * @property array state
 * @property \Supplycart\Snapshot\Contracts\CaptureSnapshots model
 */
class Snapshot extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'state',
    ];

    protected $casts = [
        'state' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => SnapshotCreated::class,
        'updated' => SnapshotUpdated::class,
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function toArray()
    {
        return $this->state;
    }
}