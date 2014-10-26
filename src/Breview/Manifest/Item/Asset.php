<?php 
namespace Breview\Manifest\Item;
class Asset {
	protected $data;
	public function __construct($data) {
		$this->data = $data;
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