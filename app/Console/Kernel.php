<?php

namespace App\Console;

use App\Jobs\ScheduleJobs\ContinueClassCheck;
use App\Jobs\ScheduleJobs\GetClassinLessonVideo;
use App\Jobs\ScheduleJobs\GetOldLessons;
use App\Jobs\ScheduleJobs\HealthReportNotice;
use App\Jobs\ScheduleJobs\LessonWatch;
use App\Jobs\ScheduleJobs\MorningLessonNumQuery;
use App\Jobs\ScheduleJobs\QueryForeignTeacher;
use App\Jobs\SendHotNews;
use App\Jobs\WeatherReport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new SendHotNews())->dailyAt('8:20');
        $schedule->job(new WeatherReport())->dailyAt('7:30');
        $schedule->job(new LessonWatch())->everyMinute();
        $schedule->job(new MorningLessonNumQuery())->dailyAt('17:55');
        $schedule->job(new GetClassinLessonVideo())->everyMinute();
        $schedule->job(new GetOldLessons())->everyMinute()->withoutOverlapping();
        $schedule->job(new QueryForeignTeacher())->everyTwoHours();
        $schedule->job(new ContinueClassCheck())->dailyAt('17:55');
//        $schedule->job(new HealthReportNotice())->dailyAt('20:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
