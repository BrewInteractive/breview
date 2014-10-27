<?php 
namespace Breview\Manifest\Item;
class Asset {
	protected $data;
	protected $adapter;
	public function __construct($data, $params = array()) {
		$this->data = $data;
		$this->adapter = (is_array($params) && array_key_exists('adapter', $params)) ? $params['adapter'] : null;
	}
	public function __get($param) {
		if(array_key_exists($param, $this->data)) {
			$targetAttributeClassName = __NAMESPACE__ . '\Attribute\\' . ucfirst($param);
			if(class_exists($targetAttributeClassName)) {
				if($param == 'path') {
					$targetAttributeClassParams['adapter'] = $this->adapter;
				}
				return new $targetAttributeClassName($this->data[$param], $targetAttributeClassParams);
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