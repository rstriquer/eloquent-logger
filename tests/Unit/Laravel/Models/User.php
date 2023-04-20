<?php

// namespace Tests\Unit\Laravel\Models;

namespace Rstriquer\EloquentLogger\Tests\Unit\Laravel\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use RStriquer\EloquentLogger\Tests\Unit\Laravel\Factories\UserFactory;

class User extends Model
{
    // use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    // /**
    //  * Create a new factory instance for the model.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
    //  */
    // protected static function newFactory()
    // {
    //     return new UserFactory();
    // }
}
