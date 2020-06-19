<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['position', 'salary', 'job_allowance'];

    public $timestamps = false;

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }
}
