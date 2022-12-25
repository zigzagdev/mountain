<?php

namespace App\Console\Commands;

use App\Models\Api\News;
use Illuminate\Console\Command;

class ReadNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
     *
     */
    public function handle()
    {
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        echo News::whereBetween('created_at', [$from, $to])->get()->count();
    }
}
