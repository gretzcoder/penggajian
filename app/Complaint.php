<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['employee_id', 'subject', 'body'];

    public function complain_images()
    {
        return $this->hasMany('App/ComplaintImage');
    }
}
