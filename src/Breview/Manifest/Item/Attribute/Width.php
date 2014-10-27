<?php 
namespace Breview\Manifest\Item\Attribute;
class Width extends AbstractAttribute {
	protected $format = '%d px';
	public static $title = 'Width';
	public function __tostring() {
		return sprintf($this->format, $this->data);
	}
}