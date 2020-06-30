<?php

use App\PayrollHistory;
use App\Position;
use Illuminate\Database\Seeder;

class PayrollHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayrollHistory::truncate();

        $z = Carbon\Carbon::now()->subMonth()->endOfMonth();

        PayrollHistory::updateOrCreate([
            'id' => 1,
            'employee_id' => 2,
            'gaji_pokok' => 7500000,
            'penambahan' => 500000,
            'potongan' => 200000,
            'gaji_bersih' => 7800000,
            'created_at' => $z
        ]);

        PayrollHistory::updateOrCreate([
            'id' => 2,
            'employee_id' => 3,
            'gaji_pokok' => 4000000,
            'penambahan' => 250000,
            'potongan' => 250000,
            'gaji_bersih' => 4000000,
            'created_at' => $z
        ]);
    }
}
