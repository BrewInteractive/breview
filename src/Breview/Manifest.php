<?php 
namespace Breview;
class Manifest {
	protected $adapter, $data, $cache;
	public function __construct($params = array()) {
		$this->cache = array_key_exists('cache', $params) ? $params['cache'] : null;
		if(array_key_exists('url', $params)) {
			$this->adapter = new Manifest\Adapter\Remote($params['url'], array('cache' => $params['cache']));
			$this->data = $this->adapter->getManifest();
		}
		else {
			throw new Exception('No adapter found.');
		}
	}
	public function __get($param) {
		if($param == 'items') {
			$items = array();
			foreach($this->data['items'] as $item) {
				$items[] = new Manifest\Item($item, array('adapter' => $this->adapter));
			}
			return $items;
		}
		return $this->data[$param];
	}
	public function __isset($param) {	
		if(array_key_exists($param, $this->data)) {
			return true;
		}
		return false;
	}
	public function findItemBy($keyword, $value, $params = array()) {
		$hash_algorithm = array_key_exists('hash_algorithm', $params) ? $params['hash_algorithm'] : null;
		if($this->items !== null) {
			foreach($this->items as $item) {
				$item_keyword = ($hash_algorithm !== null) ? hash($hash_algorithm, $item->{$keyword}) : $item->{$keyword};
				if($item_keyword == $value) {
					return $item;
				}
			}
			throw new \Exception('No matching item was found');
		}
		else {
			throw new \Exception('Items not found.');
		}
	}
}