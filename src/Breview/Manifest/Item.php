<?php 
namespace Breview\Manifest;
class Item {
	protected $data;
	protected $adapter;
	public function __construct($data) {
		$this->data = $data;
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
					$assets[] = new Item\Asset($asset);
				}
				elseif(gettype($asset) == 'string') {
					$assets[] = new Item\Asset(array_merge(
						$this->data['attributes'], 
						array('path' => $asset)
					));
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
					$attributes[] = new $targetAttributeClassName($attribute);
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
	public function getAttribute($attr_name) {
		if(array_key_exists($attr_name, $this->data['attributes'])) {
			$targetAttributeClassName = __NAMESPACE__ . '\Item\Attribute\\' . ucfirst($attr_name);
			if(class_exists($targetAttributeClassName)) {
				return new $targetAttributeClassName($this->data['attributes'][$attr_name]);
			}
			return $this->data['attributes'][$attr_name];
		}
		return null;
	}
}