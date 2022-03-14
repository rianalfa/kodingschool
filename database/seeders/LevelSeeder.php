<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $point = 200;
        $total = 0;
        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 50;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 75;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 100;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 125;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 150;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 175;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 200;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 225;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 250;
        }

        for ($i=0; $i<10; $i++) {
            $total += $point;
            DB::table('levels')->insert([
                'point' => $point,
                'point_total' => $total,
            ]);
            $point += 300;
        }
    }
}
