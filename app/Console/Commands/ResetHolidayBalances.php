<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\HolidayBalance;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetHolidayBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:reset-holiday-balances';
    protected $signature = 'holiday:reset-balances';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();
        $year = $today->year;

        if ($today->lt(Carbon::create($year, 4, 6))) {
            $start = Carbon::create($year - 1, 4, 6);
            $end = Carbon::create($year, 4, 5);
        } else {
            $start = Carbon::create($year, 4, 6);
            $end = Carbon::create($year + 1, 4, 5);
        }

        foreach (Employee::all() as $employee) {
            HolidayBalance::firstOrCreate([
                'employee_id' => $employee->id,
                'holiday_year_start' => $start->toDateString(),
            ], [
                'holiday_year_end' => $end->toDateString(),
                'total_days' => $employee->total_holiday_days,
            ]);
        }

        $this->info('Holiday balances for new year have been set.');
    }

}