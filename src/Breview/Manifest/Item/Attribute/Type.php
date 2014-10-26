<?php 
namespace Breview\Manifest\Item\Attribute;
class Type extends AbstractAttribute {
	public static $title = 'Type';
	public function __tostring() {
		return ucfirst($this->data);
	}
}