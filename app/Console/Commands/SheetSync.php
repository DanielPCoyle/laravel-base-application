<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SheetsController;

class SheetSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheets:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will sync your migration files with your Google Sheets file.';
    private $sheets;

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
        $this->sheets->do();
    }
}
