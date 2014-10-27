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
	public function get() {}
	public function save() {}
	public function check() {}
    public static function isFullUrl($url) {
        $urlParts = parse_url($url);
        return isset($urlParts['scheme']) ? true : false;
    }
}