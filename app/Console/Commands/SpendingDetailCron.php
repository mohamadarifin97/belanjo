<?php

namespace App\Console\Commands;

use App\Models\Spending;
use Illuminate\Console\Command;

class SpendingDetailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spendingDetail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create relationship from Spendings table';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $spendings = Spending::all();

        $spendings->each(function($spending) {
            foreach ($spending['spend_list'] as $key => $value) {
                Spending::find($spending->id)->spendingDetails()->create([
                    'spend' => $key,
                    'value' => $value
                ]);
            }
        });
    }
}
