<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function presences()
    {
        return $this->hasMany('App\Presence');
    }

    public function complaints()
    {
        return $this->hasMany('App\Complaint');
    }
    public function payrollHistories()
    {
        return $this->hasMany('App\PayrollHistory');
    }
}
