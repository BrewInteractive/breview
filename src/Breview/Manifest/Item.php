<?php 
namespace Breview\Manifest;
class Item {
	protected $data;
	protected $adapter;
	public function __construct($data, $params = array()) {
		$this->data = $data;
		$this->adapter = (is_array($params) && array_key_exists('adapter', $params)) ? $params['adapter'] : null;
	}
	public function __get($param) {
		if($param == 'assets') {
			$assets = array();
			foreach($this->data['assets'] as $asset) {
				if(gettype($asset) == 'array') {
					$asset = array_merge(
						$this->data['attributes'],
						$asset
					);
					$assets[] = new Item\Asset($asset, array('adapter' => $this->adapter));
				}
				elseif(gettype($asset) == 'string') {
					$assets[] = new Item\Asset(array_merge(
						$this->data['attributes'], 
						array('path' => $asset)
					), array('adapter' => $this->adapter));
				}
				else {
					throw new \Exception('Path or an object containing a path to an asset must be provided.');
				}
			}
			return $assets;
		}
		elseif($param == 'attributes') {
			$attributes = array();
			foreach($this->data['attributes'] as $attribute) {
				$targetAttributeClassName = __NAMESPACE__ . '\Item\Attribute\\' . ucfirst($attribute);
				if(class_exists($targetAttributeClassName)) {
					$targetAttributeClassParams = array();
					if($attribute == 'path') {
						$targetAttributeClassParams['adapter'] = $this->adapter;
					}
					$attributes[] = new $targetAttributeClassName($attribute, $targetAttributeClassParams);
				}
				$attributes[] = $attribute;
			}
		}
		return $this->data[$param];
	}
	public function __isset($param) {
		if(array_key_exists($param, $this->data)) {
			return true;
		}
		return false;
	}
	public function getAttribute($attribute) {
		if(array_key_exists($attribute, $this->data['attributes'])) {
			$targetAttributeClassName = __NAMESPACE__ . '\Item\Attribute\\' . ucfirst($attribute);
			if(class_exists($targetAttributeClassName)) {
				if($attribute == 'path') {
					$targetAttributeClassParams['adapter'] = $this->adapter;
				}
				return new $targetAttributeClassName($this->data['attributes'][$attribute], $targetAttributeClassParams);
			}
			return $this->data['attributes'][$attribute];
		}
		return null;
	}
}