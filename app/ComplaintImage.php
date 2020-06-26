<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintImage extends Model
{
    protected $fillable = ['complaint_id', 'complaint_image'];

    public function Complaint()
    {
        return $this->belongsTo('App\Complaint');
    }
}
