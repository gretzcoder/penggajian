<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $fillable = ['name', 'formula', 'condition', 'type'];
    public $timestamps = false;

    public function HitungPenambahanPotongan($employee, $firstMonth, $lastMonth)
    {
        $position = Position::where('id', $employee->position->id)->first();
        $gaji = $position->salary;
        $absen = count($employee->presences->where('status', 'a')->where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->all());
        $terlambat = count($employee->presences->where('status', 't')->where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->all());
        $hadir = count($employee->presences->where('status', 'h')->where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->all());
        $menikah = $employee->marital_status;
        $anak = $employee->number_of_children;

        $formula = $this->formula;
        $condition = $this->condition;

        $formula = trim($formula);     // trim white spaces
        $math1 = preg_replace('/g/', $gaji, $formula);    // remove any non-numbers chars; exception for math operators
        $math2 = preg_replace('/a/', $absen, $math1);    // remove any non-numbers chars; exception for math operators
        $math3 = preg_replace('/t/', $terlambat, $math2);    // remove any non-numbers chars; exception for math operators
        $math4 = preg_replace('/h/', $hadir, $math3);    // remove any non-numbers chars; exception for math operators
        $math5 = preg_replace('/m/', $menikah, $math4);    // remove any non-numbers chars; exception for math operators
        $math6 = preg_replace('/c/', $anak, $math5);    // remove any non-numbers chars; exception for math operators
        $math = preg_replace('/[^0-9\+\-\*\/\(\) ]/', '', $math6);    // remove any non-numbers chars; exception for math operators

        $condition = trim($condition);     // trim white spaces
        $condition1 = preg_replace('/g/', $gaji, $condition);    // remove any non-numbers chars; exception for math operators
        $condition2 = preg_replace('/a/', $absen, $condition1);    // remove any non-numbers chars; exception for math operators
        $condition3 = preg_replace('/t/', $terlambat, $condition2);    // remove any non-numbers chars; exception for math operators
        $condition4 = preg_replace('/h/', $hadir, $condition3);    // remove any non-numbers chars; exception for math operators
        $condition5 = preg_replace('/m/', $menikah, $condition4);    // remove any non-numbers chars; exception for math operators
        $condition6 = preg_replace('/c/', $anak, $condition5);    // remove any non-numbers chars; exception for math operators
        $condition = preg_replace('/[^0-9\+\-\*\/\(\)\=\<\>\&\|\! ]/', '', $condition6);    // remove any non-numbers chars; exception for math operators

        if ($condition == '1') {
            return eval('return  ' . $math . ';');
        } else if (!preg_match('/^[0-9].*[0-9]$/', $condition)) {
            $condition = 0;
        } else {
            return eval('
            if(' . $condition . '){
                return  ' . $math . ';
            } else{
                return 0;
            }');
        };
    }
}
