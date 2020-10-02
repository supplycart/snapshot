<?php

namespace Supplycart\Snapshot\Tests\Stubs;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Supplycart\Snapshot\Contracts\CaptureSnapshots;
use Supplycart\Snapshot\Traits\HasSnapshots;

class User extends Model implements CaptureSnapshots
{
    use HasSnapshots;

    protected $guarded = [];

    protected $hidden = ['password'];

    public static function stub(): User
    {
        $faker = Factory::create();

        $user = new User;
        $user
            ->fill([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('secret'),
            ])
            ->save();

        return $user;
    }
}