<?php
date_default_timezone_set('Europe/Istanbul');
$config['twig'] = array(
	'twig.path' => 'views',
    'twig.options' => array(
    	'cache' => false,
    	'autoescape' => false,
    ),
);
$config['s3'] = array();
return $config;