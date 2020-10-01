<?php

namespace Supplycart\Snapshot\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Supplycart\Snapshot\Contracts\CaptureSnapshots;
use Supplycart\Snapshot\Traits\HasSnapshots;
use Illuminate\Foundation\Testing\WithFaker;

class User extends Model implements CaptureSnapshots
{
    use HasSnapshots, WithFaker;

    protected $guarded = [];

    protected $hidden = ['password'];

    public static function stub(): User
    {
        $user = new User;
        $user->setUpFaker();

        $user
            ->fill([
                'name' => $user->faker->name,
                'email' => $user->faker->email,
                'password' => Hash::make('secret'),
            ])
            ->save();

        return $user;
    }
}