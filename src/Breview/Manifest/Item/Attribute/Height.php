<?php 
namespace Breview\Manifest\Item\Attribute;
class Height extends AbstractAttribute {
	protected $format = '%d px';
	public static $title = 'Height';
	public function __tostring() {
		return sprintf($this->format, $this->data);
	}
}