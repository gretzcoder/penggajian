<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();


        User::updateOrCreate([
            'id' => 1,
            'nip' => 'cakecode',
            'password' => bcrypt('00000000'),
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
