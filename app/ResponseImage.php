<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseImage extends Model
{
    public function Response()
    {
        return $this->belongsTo('App\Response');
    }
}
