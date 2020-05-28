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
            'position' => 'Human Resource',
            'salary' => 4500000,
            'job_allowance' => 750000
        ]);

        Position::updateOrCreate([
            'position' => 'Staff',
            'salary' => 4000000,
            'job_allowance' => 500000
        ]);
    }
}
