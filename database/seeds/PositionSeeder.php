<?php

use App\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('positions')->delete();


        Position::updateOrCreate([
            'id' => 2,
            'position' => 'Staff',
            'salary' => 4000000,
            'job_allowance' => 250000
        ]);
        Position::updateOrCreate([
            'id' => 3,
            'position' => 'Manajer',
            'salary' => 7500000,
            'job_allowance' => 500000
        ]);
    }
}
