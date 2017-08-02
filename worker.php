<?php
chdir(dirname(__FILE__));

include_once("database.php");
include_once("functions.php");
include_once("classes.php");


	$files = glob(__DIR__ . '/tasks/*.php');

	foreach($files as $file) {
		require_once($file);
		
	}
	


use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;

use Illuminate\Contracts\Debug\ExceptionHandler;


class MyHandler implements ExceptionHandler
{
	public function report(Exception $e) {
		var_dump($e);
	}


    public function render($request, Exception $e)
    {
    	echo("render");
    }


    public function renderForConsole($output, Exception $e){
    	echo("renderforconsole");
    }
}



$worker = new Worker($queue->getQueueManager(), $capsule->getEventDispatcher(), new MyHandler());


// Run indefinitely
while (true) {
    // Parameters: 
    // 'default' - connection name
    // 'default' - queue name
    // delay
    // time before retries
    // max number of tries
    

    $worker->runNextJob('default', 'default', new WorkerOptions());


}


?>