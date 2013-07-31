<?php
Configure::write('Session', Hash::merge(
	Configure::read('Session'),
	array(
		'defaults' => 'php',
		'handler' => array(
			'engine' => 'RedisSession.RedisSession',
			//'prefix' => 'PHPREDIS_SESSION',
			//'host' => 'localhost',
			//'port' => '6379',
		),
	)
));
