<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FacadeInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade:info {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show class name that mapping to specific Facade';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $name = $this->argument('name');
        $name = ucfirst($name);
        $facadeName = "Illuminate\\Support\\Facades\\".$name;
        $instance = call_user_func_array(array($facadeName, 'getFacadeRoot'),[]);
        $this->info((new \ReflectionClass($instance))->name);
    }
}
