<?php

namespace App\Listeners;

use App\Events\StatusUpdated;
use App\Notifications\EmployeeNotificationBookingUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmployeeNotifyStatusUpdated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatusUpdated $event): void
    {
        $email = $event->appointment->employee->user->email;
        \Notification::route('mail',$email)->notify(new EmployeeNotificationBookingUpdated($event->appointment));
    }
}
