<?php

/**
 * THE MUSEUM object with all its properties according to db structure
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace Museo\Model;

use Museo\Lib\DbObject;
use Museo\Lib\DbObjectInterface;

class Museum extends DbObject implements DbObjectInterface
{
	protected $id = null;
	protected $name = "";
	protected $categories = array();
	protected $description = "";
			
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
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		return ($this->description = $description);
	}
	
	public function getCategories() {
		if (is_null($this->categories)) {
		// TODO : Query to select categories of the museum (if not set yet)
		}		
		return $this->categories;
	}
	
	public function setCategories($categories) {
		if (!(is_array($categories))) throw false;
		return $this->categories = $categories;
	}
	
	public function hasCategory(Category $category) {
		return in_array($category, $this->getCategories());
	}
	
	public function addCategory(Category $category) {
		if (!(is_array($this->categories))) $this->categories = Array();
		return ($this->categories[] = $category);
	}
	
	public function removeCategory($category) {
		return $this->categories[] = $category;
	}

	// object transformation
	public function toArray() {
		// collapse categories IDS in an array
		$categoriesIds = array();
		foreach ($this->getCategories() as $category) {
			$categoriesIds[] = $category->getId();	
		}
		$data = array(
			'id'          => $this->getId(),
			'name'        => $this->getName(),
			'description' => $this->getDescription(),
			'categories'  => $categoriesIds,
		);
		
		return $data;
	}
	
	// dbObject requirements
	static function getFields() {
		return array('id','name','description');
	}
			
	static function getTableName() {
		return "museum";
	}
	
}
