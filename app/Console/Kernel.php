<?php

namespace App\Console;

use App\Console\Commands\CreateMobileTenders;
use App\Console\Commands\Dxi\GetDxiCallsForTheLastFiveMinutes;
use App\Console\Commands\Dxi\GetTodaysDxiLogins;
use App\Console\Commands\GenerateCifForm;
use App\Console\Commands\ProcessMobileTenders;
use App\Console\Commands\UpdatePhoneList;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateCashFlow;
use App\Console\Commands\UpdateTimeAtAddress;
use App\Console\Commands\UpdateBcadRequired;
use App\Console\Commands\ResetBondPayment;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdatePhoneList::class,
        CreateMobileTenders::class,
        ProcessMobileTenders::class,
        GetTodaysDxiLogins::class,
        GetDxiCallsForTheLastFiveMinutes::class,
        GenerateCifForm::class,
        UpdateCashFlow::class,
        UpdateTimeAtAddress::class,
        UpdateBcadRequired::class,
        ResetBondPayment::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('atlas:update-phone-list')
                 ->monthlyOn(1, '02:00');

        $schedule->command('atlas:create-mobile-tenders')
                 ->weekly()
                 ->fridays()
                 ->at('17:00');

        $schedule->command('atlas:process-mobile-tenders')
                 ->dailyAt('17:15');

        $schedule->command('atlas:get-todays-dxi-logins')
                 ->everyFiveMinutes()
                 ->between('8:00', '19:00');

        $schedule->command('atlas:get-dxi-calls')
                 ->everyFiveMinutes()
                 ->between('8:00', '19:00');

        $start = Carbon::now()->subHours(1)->format('y-m-d h:i:s');
        $end   = Carbon::now()->addMinutes(2)->format('y-m-d h:i:s');

        $schedule->command("atlas:get-dxi-calls '" . $start . "' '" . $end . "'")
                 ->everyThirtyMinutes()
                 ->between('8:00', '19:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
