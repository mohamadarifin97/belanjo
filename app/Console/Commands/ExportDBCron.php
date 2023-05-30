<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ExportDBCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exportDB:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup DB monthly';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('Exporting Belanjo DB at '.now());

        $command = 'pg_dump';
        $db_name = env('DB_DATABASE');
        $db_username = env('DB_USERNAME');
        $db_path = env('DB_BACKUP_PATH');
        $time = Carbon::now()->format('Ymd_his');
        $arguments = [
            '--dbname='.$db_name,
            '--username='.$db_username,
            '--file='.$db_path.$time.'.sql'
        ];

        $process = new Process([$command, ...$arguments]);
        $process->run();

        if ($process->isSuccessful()) {
            Log::info('Export Belanjo DB success.');
        } else {
            Log::error('Export Belanjo DB fail');
            Log::error($process->getErrorOutput());
        }
    }
}
