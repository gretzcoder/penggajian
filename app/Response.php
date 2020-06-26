<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['status', 'complaint_id', 'subject', 'response'];

    public function complaint()
    {
        return $this->hasOne('App\Complaint');
    }

    public function response_images()
    {
        return $this->hasMany('App\ResponseImage');
    }
}
