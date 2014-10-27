<?php 
namespace Breview\Manifest\Item\Attribute;
class Path extends AbstractAttribute {
	public static $title = 'Path';
	public function __tostring() {
		if(\Breview\Manifest\Adapter\Remote::isFullUrl($this->data)) {
			return $this->data;
		}
		return $this->adapter->url . '/' . $this->data;
	}
}