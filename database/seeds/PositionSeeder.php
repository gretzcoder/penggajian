<?php

use App\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::updateOrCreate([
            'id' => 2,
            'position' => 'Staff',
            'salary' => 4000000,
            'job_allowance' => 500000
        ]);
    }
}
