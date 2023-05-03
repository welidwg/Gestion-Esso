<?php

namespace App\Console\Commands;

use App\Models\ArchiveSolde;
use App\Models\Compte;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReinitSolde extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reinit:sold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $solde = Compte::latest()->first();
        $old = $solde->montant;
        $solde->montant = 0;
        $previousDate = $today->subDay();
        $data = ["solde" => $old, "date" => $previousDate];
        ArchiveSolde::create($data);
        if ($today->day == 1) {
            // Today is the first day of the month
            // Your code here

        }
        return 0;
    }
}
