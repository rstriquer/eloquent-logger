<?php

namespace RStriquer\EloquentLogger\Tests\Unit\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $guarded = [];
}
