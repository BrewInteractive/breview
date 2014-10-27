<?php 
namespace Breview\Manifest\Adapter;
abstract class AbstractAdapter {
	public $url, $data;
    public $manifestFilename = 'breview.json';
	protected function getCache() {
		/*
		$cache = \Zend\Cache\StorageFactory::factory(array(
    		'adapter' => array(
        		'name' => 'filesystem'
    		),
    		'options' => array(
    			'cache_dir' => './cache',
    		),
    		'plugins' => array(
        		'exception_handler' => array(
            		'throw_exceptions' => true
        		),
    		)
		));
		*/
	}
}