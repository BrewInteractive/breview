<?php
date_default_timezone_set('Europe/Istanbul');
$config['twig'] = array(
	'twig.path' => 'views',
    'twig.options' => array(
    	'cache' => false,
    	'autoescape' => false,
    ),
);
$config['db'] = array(
	'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'),
	'id_column' => 'ID',
	'caching' => false,
);
return $config;
