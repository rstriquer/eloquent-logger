<?php

declare(strict_types=1);

namespace Rstriquer\EloquentLogger\Tests\Unit\Laravel;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Rstriquer\EloquentLogger\DatabaseServiceProvider;
use Rstriquer\EloquentLogger\Tests\Unit\Laravel\Models\User;

class AuthServiceProviderTest extends TestCase
{
    protected $app_mock;

    public static function setUpBeforeClass(): void
    {
        if (getenv('DB_LOGGER_ACTIVE') || getenv('DB_LOGGER_FILE')) {
            throw new InvalidArgumentException(
                'Neither DB_LOGGER_ACTIVE nor DB_LOGGER_FILE should be set'
                .' on test environment'
            );
        }
        putenv('DB_LOGGER_ACTIVE="/logs/query.log"');
        parent::setUpBeforeClass();
    }

    public function setUp(): void
    {
        $this->app_mock = $this->createApplication();
    }

    /**
     * Build and seed the database to an sqlite database on memory
     */
    public function loadDatabase(): void
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $capsule->bootEloquent();
        $capsule->setAsGlobal();
        $this->db = $capsule->getDatabaseManager();
        $capsule->schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
        });
    }

    /**
     * @test
     */
    public function ObjectConstructionOkWhenDB_LOGGER_ACTIVEIsOff()
    {
        putenv('DB_LOGGER_ACTIVE=false');
        $this->assertInstanceOf(
            DatabaseServiceProvider::class,
            new DatabaseServiceProvider(['auth' => $this->app_mock])
        );
    }

    /**
     * @test
     */
    public function ObjectConstructionOkWhenDB_LOGGER_ACTIVEIsOn()
    {
        putenv('DB_LOGGER_ACTIVE=true');
        $this->assertInstanceOf(
            DatabaseServiceProvider::class,
            new DatabaseServiceProvider(['auth' => $this->app_mock])
        );
    }

    /**
     * @test
     */
    public function DoesNotCallWriteToFileOk()
    {
        putenv('DB_LOGGER_ACTIVE=false');
        $this->loadDatabase();
        File::shouldReceive('append')->never();
        for ($i = 0; $i < 10; $i++) {
            $user = app(User::class);
            $user->fill([
                'name' => Str::random(10),
                'email' => Str::random(10),
            ]);
            $user->save();
        }
        $user = app(User::class)->where('id', '1')->get();
        $this->assertInstanceOf(Collection::class, $user);
        $this->assertInstanceOf(User::class, $user[0]);
    }

    /**
     * @test
     */
    public function CallWriteToFileOk()
    {
        putenv('DB_LOGGER_ACTIVE=true');
        $this->loadDatabase();
        File::shouldReceive('append')->andReturn([]);
        for ($i = 0; $i < 10; $i++) {
            $user = app(User::class);
            $user->fill([
                'name' => Str::random(10),
                'email' => Str::random(10),
            ]);
            $user->save();
        }
        $user = app(User::class)->where('id', '1')->get();
        $this->assertInstanceOf(Collection::class, $user);
        $this->assertInstanceOf(User::class, $user[0]);
    }
}
