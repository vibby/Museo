<?php

/**
 * THE CATEGORY object with all its properties according to db structure
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace Museo\Model;

use Museo\Lib\DbObject;
use Museo\Lib\DbObjectInterface;

class Category extends DbObject implements DbObjectInterface
{
	protected $id = null;
	protected $name = "";
	protected $parent = null;
	protected $parentId = null;
	protected $children = array();
		
	// all the getters and setters
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		return $this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		return ($this->name = $name);
	}
	
	public function getParent() {
		return $this->parent;
	}
	
	public function setParent(Category $parent) {
		return ($this->parent = $parent);
	}
	
	public function getParentid() {
		return $this->parentid;
	}
	
	public function setParentId($parentid) {
		return ($this->parentid = $parentid);
	}
	
	public function getChildren() {
		return $this->children;
	}
	
	public function setChildren($children) {
		return ($this->children = $children);
	}
	
	// transformation logic
	public function toArray() {
	
		$data = array(
			'id'          => $this->getId(),
			'name'        => $this->getName(),
			'parentid'   => $this->getParentid(),
		);
		
		return $data;
	}
	
	// dbObject requirements
	static function getTableName() {
		return "category";
	}
	
	static function getFields() {
		return array('id','name','parentid');
	}
	
}
