<?php
namespace Breview\Manifest\Adapter;
class Remote extends AbstractAdapter {
	public function __construct($url) {
		$this->url = rtrim($url, '/');
	}
	public function getManifest() {
		$client = new \GuzzleHttp\Client();
		return $client->get($this->url . '/' . $this->manifestFilename)->json();
	}
	public function getFile() {}
	public function saveLocal() {}
	public function checkExists() {}
}