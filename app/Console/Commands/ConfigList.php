<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConfigList extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'config:list {name}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show the configurations by name ';

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
		if (!$name) $name = 'app';
		//        $this->table(['a','b'], [['a'=>'apple', 'b'=>'banana']]);
		$this->line(var_export(config($name), 1));
		//        $this->info(json_encode(config($name)));
	}
}
