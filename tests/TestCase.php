<?php

namespace Supplycart\Snapshot\Tests;

use CreateSnapshotsTable;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Base;

abstract class TestCase extends Base
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->app->get('db')->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });

        include_once __DIR__ . '/../database/migrations/create_snapshots_table.php.stub';

        (new CreateSnapshotsTable())->up();
    }
}