<?php

namespace App\Console;

use App\Models\Badge;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $topThree = DB::table('results')
                            ->selectRaw('results.user_id, users.name, sum(results.point) as points')
                            ->leftJoin('users', 'results.user_id', '=', 'users.id')
                            ->groupBy('results.user_id', 'users.name')
                            ->where('results.date', 'like', date('Y-m').'%')
                            ->orderBy('points', 'desc')
                            ->take(3)
                            ->get();
            $i=1;
            foreach ($topThree as $top) {
                Badge::insert([
                    'user_id' => $top->user_id,
                    'rank' => $i,
                    'point' => $top->points,
                ]);
                $i++;
            }

        })->lastDayOfMonth('23:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
