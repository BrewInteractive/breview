<?php
namespace Breview\Manifest\Adapter;
class Remote extends AbstractAdapter {
	public $url;
	public $manifestFilename = 'breview.json';
	public function __construct($url, $params = array()) {
		$this->cache = array_key_exists('cache', $params) ? $params['cache'] : null;
		$this->url = rtrim($url, '/');
	}
	public function getManifest() {
		$manifest = null;
		if($this->cache !== null) {
			$cache = \Zend\Cache\StorageFactory::factory($this->cache);
			$cacheKey = hash('crc32b', $this->url);
			$manifest = $cache->getItem($cacheKey, $isGood);
			if($isGood !== true) {
				$response = $this->_getManifest();
    			$cache->setItem($cacheKey, serialize($response));
    			return $response;
			}
			return unserialize($manifest);
		}
		return $this->_getManifest();
	}
    public static function isFullUrl($url) {
        $urlParts = parse_url($url);
        return isset($urlParts['scheme']) ? true : false;
    }
    private function _getManifest() {
		$client = new \GuzzleHttp\Client();
		return $client->get($this->url . '/' . $this->manifestFilename)->json();
    }
}