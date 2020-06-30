<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(PresenceSeeder::class);
        $this->call(PayrollHistorySeeder::class);
    }
}
