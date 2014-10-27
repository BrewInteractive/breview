<?php 
namespace Breview\Manifest\Item\Attribute;
abstract class AbstractAttribute {
	protected $data, $adapter;
	public static $title;
	public function __construct($data, $params = array()) {
		$this->data = $data;
		$this->adapter = (is_array($params) && array_key_exists('adapter', $params)) ? $params['adapter'] : null;
	}
	public function getValue() {
		return $this->data;
	}
	public function __tostring() {
		return sprintf($this->format, $this->data);
	}
}