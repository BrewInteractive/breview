<?php
namespace Breview\Manifest\Adapter;
class Remote extends \Breview\Manifest\Adapter {
	public function __construct($url) {
		$client = new \GuzzleHttp\Client();
		/*
		$key = 'unique-cache-key';
		$this->data = $cache->getItem($key, $success);
		if(!$success) {
			$client = new Client();
			$this->data = $client->get($this->url)->json();
    		$cache->setItem($key, $this->data);
		}
		*/
		$this->data = $client->get($url)->json();
	}
	public function __get($param) {
		return $this->data[$param];
	}
	public function __isset($param) {
		if(array_key_exists($param, $this->data)) {
			return true;
		}
		return false;
	}
}