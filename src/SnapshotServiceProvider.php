<?php

namespace Supplycart\Snapshot;

use Illuminate\Support\ServiceProvider;

class SnapshotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (!class_exists('CreateSnapshotsTable')) {
                $path = __DIR__ . '/../database/migrations/create_snapshots_table.php.stub';

                $this->publishes([
                    $path => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_snapshots_table.php'),
                ], 'migrations');
            }
        }
    }
}