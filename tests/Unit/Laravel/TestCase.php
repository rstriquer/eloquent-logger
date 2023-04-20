<?php

namespace Rstriquer\EloquentLogger\Tests\Unit\Laravel;

use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates a new instance of Laravel Application.
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function createApplication()
    {
        $app = $this->createPartialMock(Application::class, ['runningInConsole', 'runningUnitTests']);

        Container::setInstance($app);

        $app->singleton(
            ExceptionHandler::class,
            function () use ($app) {
                return new \Illuminate\Foundation\Exceptions\Handler($app);
            }
        );

        return $app;
    }
}
