<?php 
namespace Breview\Manifest\Item\Attribute;
abstract class AbstractAttribute {
	protected $data, $format;
	public static $title;
	public function __construct($param) {
		$this->data = $param;
	}
	public function getValue() {
		return $this->data;
	}
	public function getTitle() {
		return $this->title;
	}
	public function __tostring() {
		return sprintf($this->format, $this->data);
	}
}