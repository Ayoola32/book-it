<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the holiday reset command yearly on April 6
return function (Schedule $schedule) {
    $schedule->command('holiday:reset-balances')->yearlyOn(4, 6, '00:00');
};