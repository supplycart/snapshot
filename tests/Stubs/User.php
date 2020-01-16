<?php

namespace Supplycart\Snapshot\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Supplycart\Snapshot\Contracts\CaptureSnapshots;
use Supplycart\Snapshot\Traits\HasSnapshots;

class User extends Model implements CaptureSnapshots
{
    use HasSnapshots;

    protected $guarded = [];

    protected $hidden = ['password'];
}