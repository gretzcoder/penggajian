<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['employee_id', 'subject', 'body'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function complaint_images()
    {
        return $this->hasMany('App\ComplaintImage');
    }

    public function response()
    {
        return $this->hasOne('App\Response');
    }
}
