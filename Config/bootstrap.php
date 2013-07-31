<?php
Configure::write('Session', Hash::merge(
	Configure::read('Session'),
	array(
		'defaults' => 'php',
		'handler' => array(
			'engine' => 'RedisSession.RedisSession',
			//'userMapPrefix' => 'USERS',
			//'userMapField' => 'id',
			//'prefix' => 'PHPREDIS_SESSION',
			//'host' => 'localhost',
			//'port' => '6379',
		),
	)
));
