<?php

namespace App\Console\Commands;

use App\Models\Computer;
use App\Models\ComputerLog;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CheckComputerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computer:status-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the computer is oline or offline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $computers = Computer::all();
        foreach ($computers as $key => $computer) {
            if ($computer->ip_address) {
                $process = new Process(["ping", "-c", "1", $computer->ip_address]);
                $process->run();

                if ($process->isSuccessful()) {
                    $this->info("Computer with IP: $computer->ip_address is Online");
                    if ($computer->status !='occupied') {
                        $computer->update(['status' => 'active']);
                    }
                } else {
                    if ($computer->status !='occupied') {
                        $this->info("Computer with IP: $computer->ip_address is Offline");
                        $computer->update(['status' => 'offline']);
                    }
                }
            }else{
                $this->info("Computer: $computer->computer_name doesn`t have ip address set.");
                $computer_log = $computer->logs()->latest()->first();
                if ($computer_log) {
                    $computer_log->update([
                        'created_at' => now()
                    ]);
                } else {
                 $computer->logs()->create([
                    'report' => 'No IP Address',
                    'created_at' => now()
                 ]);
                }
            }

        }
    }
}
