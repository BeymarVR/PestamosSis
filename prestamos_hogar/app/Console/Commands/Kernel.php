<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerarNotificacionesCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Ejecuta el comando diariamente a las 8:00 AM
        $schedule->command('notificaciones:generar')->dailyAt('08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}