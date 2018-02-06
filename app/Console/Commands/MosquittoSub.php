<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mosquitto\Client;

class MosquittoSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:sub {topic} {qos=0 : the QoS }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a topic';

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
		$serverIp = '127.0.0.1';
		$username = '';
		$password = '';
		$topic = $this->argument('topic');
		$qos = $this->argument('qos');
		$client  = new Client();

		$client->onConnect(function($rc, $message) {
			$this->info($message);
		});
		$client->onMessage(function($msg) {
			print_r($msg);
		});
		$client->onDisconnect(function() {
			$this->info('disconnect.');
		});

		$client->setWill('Somebody died.', 'Good bye ... ', 0, false);

		if ($username and $password) {
			$client->setCredentials($username, $password);
		}
		$client->connect($serverIp);
		$client->subscribe($topic, $qos);
		$client->loopForever();

		$client->disconnect();
		unset($client);
    }
}
