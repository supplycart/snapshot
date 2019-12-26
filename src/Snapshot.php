<?php

namespace Supplycart\Snapshot;

use Illuminate\Database\Eloquent\Model;
use Supplycart\Snapshot\Events\SnapshotCreated;
use Supplycart\Snapshot\Events\SnapshotUpdated;

class Snapshot extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'array',
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
        return $this->snapshot;
    }
}