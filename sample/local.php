<?php
$config['db'] = array(
	'connection_string' => 'mysql:host=127.0.0.1;dbname=foo',
	'username' => 'foo',
	'password' => 'bar',
);
$config['debug'] = true;
$config['localArchive'] = array(
	'basePath' => 'resources/',
	'baseUrl' => 'http://localhost/breview/resources/',
);
$config['twig'] = array();
return $config;
