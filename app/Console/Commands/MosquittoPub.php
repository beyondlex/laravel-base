<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mosquitto\Client;

class MosquittoPub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:pub {topic} {message} {qos=0} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish message to a topic.';

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
		$topic = $this->argument('topic');
		$message = $this->argument('message');
		$qos = $this->argument('qos');
		$client  = new Client();

		$client->onConnect(function($rc, $message) {
			$this->info($message);
		});
		$client->onPublish(function($msgId) {
			$this->info('Published a message with id: '. $msgId);
		});
		$client->onDisconnect(function() {
			$this->info('disconnect.');
		});

		$client->connect($serverIp);
		$client->publish($topic, $message, $qos);

		$client->disconnect();
		unset($client);
    }
}
