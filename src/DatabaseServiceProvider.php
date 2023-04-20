<?php

declare(strict_types=1);

namespace RStriquer\EloquentLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider that attach the Eloquent Console Manager listener.
 */
class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config = require __DIR__ . '/../config/database.php';

        if ($config['logger']['active']) {
            DB::listen(function ($query) use ($config) {
                $buf = str_replace(
                    ['?'], ['%s'], str_replace('%', '%%', $query->sql)
                );
                if (is_array($buf)) {
                    $buf = implode('', $buf);
                }
                File::append(
                    storage_path($config['logger']['file']),
                    '['.date('Y-m-d H:i:s').' query time:'.$query->time
                        .']'.PHP_EOL.vsprintf($buf, $query->bindings)
                        .PHP_EOL.PHP_EOL
                );
            });
        }
    }
}
