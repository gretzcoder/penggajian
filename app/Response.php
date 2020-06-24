<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['employee_id', 'complaint_id', 'subject', 'response'];
}
