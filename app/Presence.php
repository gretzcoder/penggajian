<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = ['datetime', 'status', 'employee_id', 'created_at'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
