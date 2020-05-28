<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::updateOrCreate([
            'full_name' => 'M. Iqbal Alifudin',
            'address' => '20-23 Kamiyamachō Shibuya City Tōkyō-to 150-0047 Jepang',
            'phone' => '08123456789',
            'marital_status' => 0,
            'number_of_children' => 0,
            'profile_pic' => 'default.png',
            'user_id' => 1,
            'position_id' => 1
        ]);

        Employee::updateOrCreate([
            'full_name' => 'Ahmad Nurul Fiqri',
            'address' => 'Meikarta, Indonesia',
            'phone' => '08912345678',
            'marital_status' => 1,
            'number_of_children' => 3,
            'profile_pic' => 'default.png',
            'user_id' => 2,
            'position_id' => 2
        ]);
    }
}
