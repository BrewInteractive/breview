<?php 
namespace Breview\Manifest\Item;
class Asset {
	protected $data;
	protected $adapter;
	public function __construct($data) {
		$this->data = $data;
	}
	public function __get($param) {
		if(array_key_exists($param, $this->data)) {
			$targetAttributeClassName = __NAMESPACE__ . '\Attribute\\' . ucfirst($param);
			if(class_exists($targetAttributeClassName)) {
				return new $targetAttributeClassName($this->data[$param]);
			}
			return $this->data[$param];
		}
		return null;
	}
	public function __isset($param) {
		if(array_key_exists($param, $this->data)) {
			return true;
		}
		return false;
	}
}