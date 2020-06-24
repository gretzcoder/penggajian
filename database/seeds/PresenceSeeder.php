<?php

use App\Presence;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presence::truncate();

        $a = 0;
        $z = Carbon\Carbon::parse(now()->subMonth()->firstOfMonth())->diffInDays(Carbon\Carbon::parse(now())) - 1;

        $id = 1;
        for ($a; $a <= $z + 1; $a++) {
            if (Carbon\Carbon::now()->subMonth()->firstOfMonth()->addDays($a)->isWeekDay()) {
                $d = Carbon\Carbon::now()->subMonth()->firstOfMonth()->addDays($a)->addHours(rand(1, 10) == 6  ? (rand(1, 4) == 3 ? 10 : 9) : 8)->addMinutes(rand(5, 45))->addSeconds(rand(5, 55));
                Presence::updateOrCreate([
                    'id' => $id++,
                    'datetime' => $d->toTimeString() <= '08:00:00' || $d->toTimeString() >= '10:00:00'  ? null : $d->toDatetimeString(),
                    'employee_id' => 3,
                    'status' => ($d->toTimeString() >= '08:00:00' && $d->toTimeString() <= '09:00:00'  ? 'h' : ($d->toTimeString() >= '09:00:00' && $d->toTimeString() <= '10:00:00' ? 't' : 'a')),
                    'created_at' => Carbon\Carbon::now()->subMonth()->firstOfMonth()->addDays($a)
                ]);

                $e = Carbon\Carbon::now()->subMonth()->firstOfMonth()->addDays($a)->addHours(rand(1, 15) == 6  ? (rand(1, 6) == 3 ? 10 : 9) : 8)->addMinutes(rand(5, 45))->addSeconds(rand(5, 55));
                Presence::updateOrCreate([
                    'id' => $id++,
                    'datetime' => $e->toTimeString() <= '08:00:00' || $e->toTimeString() >= '10:00:00'  ? null : $e->toDatetimeString(),
                    'employee_id' => 2,
                    'status' => ($e->toTimeString() >= '08:00:00' && $e->toTimeString() <= '09:00:00'  ? 'h' : ($e->toTimeString() >= '09:00:00' && $e->toTimeString() <= '10:00:00' ? 't' : 'a')),
                    'created_at' => Carbon\Carbon::now()->subMonth()->firstOfMonth()->addDays($a)
                ]);
            }
        }
    }
}
