<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'id' => 1,
            'nip' => 'cakecode',
            'password' => bcrypt('rahasia'),
            'is_active' => 1
        ]);

        User::updateOrCreate([
            'id' => 2,
            'nip' => '12170301',
            'password' => bcrypt('rahasia'),
            'is_active' => 1
        ]);

        User::updateOrCreate([
            'id' => 3,
            'nip' => '12170328',
            'password' => bcrypt('rahasia'),
            'is_active' => 1
        ]);
    }
}
