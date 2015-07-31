<?php 
namespace Breview\Manifest\Item\Attribute;
class Filesize extends AbstractAttribute {
	protected $format = '%d kb';
	public static $title = 'File Size';
	public function __tostring() {
		return sprintf($this->format, $this->data);
	}
}