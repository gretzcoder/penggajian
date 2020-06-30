<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollHistory extends Model
{
    protected $fillable = ['employee_id', 'gaji_pokok', 'penambahan', 'potongan', 'gaji_bersih'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
