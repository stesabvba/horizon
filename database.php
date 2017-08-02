<?php

	require_once (__DIR__ . '/modules/vendor/autoload.php');  

	use Illuminate\Database\Capsule\Manager as Capsule;  
	 
	$capsule = new Capsule; 

	 
	$capsule->addConnection(array(
		'driver'    => 'mysql',
		'host'      => 'localhost',
		'database'  => 'horizon_new',
		'username'  => 'horizon',
		'password'  => 'Cwl#5z65',
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => ''
	),"default");




	use Illuminate\Events\Dispatcher;
	use Illuminate\Container\Container;
	$capsule->setEventDispatcher(new Dispatcher(new Container));


	$capsule->setAsGlobal();
	$capsule->bootEloquent();
	
	date_default_timezone_set('Europe/Brussels');

	

	use Illuminate\Queue\Capsule\Manager as Queue;
 
	$queue = new Queue;
	 
	$queue->getContainer()->bind('encrypter', function() {
	    return new Illuminate\Encryption\Encrypter('foobar');
	});

	$queue->addConnection([
		'driver' => 'beanstalkd',
		'host' => 'localhost',
		'queue' => 'default',
	], 'default');

	$queue->setAsGlobal();



?>