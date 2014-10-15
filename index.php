<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$config = array_merge_recursive(
	include __DIR__ . '/config/local.php',
	include __DIR__ . '/config/global.php'
);
$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), $config['twig']);
$app['debug'] = $config['debug'];

$app['twig']->addFilter(new Twig_SimpleFilter('hash', function ($string) {
	return hash('crc32b', $string);
}));

/* Home */
$app->get('/', function() use($app) {
	$manifest = new Breview\Manifest(array('url' => 'http://127.0.0.1/~gokcen/breview.json'));
	return $app['twig']->render('index.twig', array(
		'manifest' => $manifest,
	));
})->bind('home');

$app->get('/preview/{id}', function($id) use($app) {
	$manifest = new Breview\Manifest(array('url' => 'http://127.0.0.1/~gokcen/breview.json'));
	$item = $manifest->findItemBy('title', $id, array('hash_algorithm' => 'crc32b'));
	return $app['twig']->render('preview.twig', array(
		'manifest' => $manifest,
		'item' => $item,
	));
})->bind('preview');

$app->run();