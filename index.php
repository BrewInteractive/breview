<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;

$config = array_merge_recursive(
	include __DIR__ . '/config/local.php',
	include __DIR__ . '/config/global.php'
);
ORM::configure($config['db']);
$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), $config['twig']);
$app['twig']->addExtension(
	new MarkdownExtension(
		new MarkdownEngine\MichelfMarkdownEngine()
	)
);
$app['debug'] = $config['debug'];
$app['controllers']
	->value('manifest', null)
	->value('item', null)
	->assert('manifest', '^\w{4,4}')
	->assert('item', '^\w{8,8}')
	->convert('manifest', function($manifest) use($app) {
		if($manifest !== null) {
			$manifestRow = ORM::forTable('manifest')
				->select('rootUrl')
				->where('urlKey', $manifest)
				->findOne();
			if($manifestRow) {
				$app['twig']->addGlobal('manifestID', $manifest);
				return new Breview\Manifest(array('url' => $manifestRow->rootUrl));
			}
			throw new \Exception('Requested resource not found.');
		}
	});
$app['twig']->addFilter(new Twig_SimpleFilter('hash', function ($string) {
	return hash('crc32b', $string);
}));
$app['twig']->addFilter(new Twig_SimpleFilter('attributeTitle', function ($attribute) {
	$targetAttributeClassName = 'Breview\Manifest\Item\Attribute\\' . ucfirst($attribute);
	if(class_exists($targetAttributeClassName)) {
		return $targetAttributeClassName::$title;
	}
}));
$app->get('/', function() use($app) {
	return $app['twig']->render('index.twig', array(
		'readme' => file_get_contents(__DIR__ . '/README.md')
	));
})->bind('home');
$app->get('/{manifest}', function($manifest) use($app) {
	return $app['twig']->render('manifest.twig', array(
		'manifest' => $manifest,
	));
})->bind('manifest');
$app->get('/{manifest}/{item}', function($manifest, $item) use($app) {
	$item = $manifest->findItemBy('title', $item, array('hash_algorithm' => 'crc32b'));
	return $app['twig']->render('preview.twig', array(
		'manifest' => $manifest,
		'item' => $item,
	));
})->bind('preview');
$app->run();