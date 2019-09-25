<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SheetsController;

class SheetsRollBack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheets:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return to a previous sync.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->sheets = new SheetsController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastSync = app_path()."/database/syncs/";
        $lastSync =str_replace("/app", "", $lastSync);
        $lastSync =str_replace("\\app", "", $lastSync);
        $files = scandir($lastSync);
        array_shift($files);
        array_shift($files);
        $file = $this->choice("Please choose a previous sync to revert to:",$files);
        $this->line("Rolling back to ".$file);
        $this->line($this->sheets->do($file));
    }
}
