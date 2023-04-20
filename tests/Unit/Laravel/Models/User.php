<?php

namespace Rstriquer\EloquentLogger\Tests\Unit\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $guarded = [];
}
