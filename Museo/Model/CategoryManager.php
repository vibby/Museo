<?php

namespace Museo\Model;

use Museo\Lib\ObjectManager;
use Museo\Lib\DbObjectInterface;

class CategoryManager extends ObjectManager implements DbObjectInterface
{

	// get the name of the table in db
	public static function getTableName() {
		return 'category';
	}

	// get the fields of the table in db
	static function getFields() {
		return array('id','name','parentid');
	}

	// define sanitizing filters
	protected static function getFilters() {
		return array(
			'name'         => FILTER_SANITIZE_STRING,
			'parentid'    => FILTER_VALIDATE_INT,
			'id'           => FILTER_VALIDATE_INT,
		);		
	}
	
	public function buildTree(\PDOStatement $pdoStatement, $fromId = null) {
	
		$pdoStatement->execute();

		$keyedArray = array();
		$roots = array();
		foreach ($pdoStatement as $dbCategory){
			$keyedArray[$dbCategory['category_parentid']][] = $dbCategory;
			$itemIds[] = $dbCategory['category_id'];
		}
		if ($fromId) {
			foreach ($keyedArray as $node){
				foreach ($node as $dbCategory){
					if ($dbCategory['category_id'] == $fromId) {
						$roots[] = $dbCategory;
					}
				}
			}
		} else {
			foreach ($keyedArray as $node){
				foreach ($node as $dbCategory){
					if (!in_array($dbCategory['category_parentid'], $itemIds)) {
						$roots[] = $dbCategory;
					}
				}
			}
		}
		
		$tree = $this->recursiveTree($keyedArray, $roots);
		
		return $tree;
	}	

	function recursiveTree($list, $parents){
	
		$tree = array();
		foreach ($parents as $parent){
			$category = new Category($parent);
			if(isset($list[$parent['category_id']])){
				$children = $this->recursiveTree($list, $list[$parent['category_id']]);
				$category->setChildren($children);
			}
			$tree[] = $category;
		} 
		return $tree;
	}
	
	function recursiveSearchInTree($tree, $value, $method = 'getId') {
	
		foreach ($tree as $item) {
			if ($item->$method() == $value) {
				return $item;
			};
			if (count($item->getChildren())) {
				$fromChildren = $this->recursiveSearchInTree($item->getChildren(), $value, $method);
				if ($fromChildren) {
					return $fromChildren;
				}
			}
		}
	}
	
	// validate data before creating object, return errors if so
	public function validateData($data) {
		
		$errors = array();
		// verify presence of required data
		if (empty($data['name'])) {
			$errors['name'][] = 'Le nom est obligatoire.';			
		}
		
		// validate data format
		if (!filter_var($data['name'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^.{4,40}$/")))) {
			$errors['name'][] = 'Le nom doit contenir entre 4 et 40 caractères.';			
		}

		// parent category cannot be a child of the current category !
		if ($data['id']) {
			if ($data['id'] == $data['parentid']) {
				$errors['parentid'][] = 'Une catégorie ne peut pas être son propre parent.';			
			} else {
					
				// create the tree from the current category
				$tree = $this->getCategoriesTree($data['id']);
				// search among children and sub-children to verify wanted parent is not here
				if ($this->recursiveSearchInTree($tree,$data['parentid'])) {
					$errors['parentid'][] = 'Impossible de sélectionner une sous-catégorie de cette catégorie.';			
				}
			}
		}
		
		return $errors;
	}	
	
	function getAll() {
	
		$query = <<<EOT
			SELECT c.id AS category_id, c.name AS category_name, c.parentid AS category_parentid
			FROM `category` AS c
			; 
EOT;
	
		return $this->db->query($query);
	}

	// Get categories tree
	public function getCategoriesTree($fromId = null) {
	
		$dbCategories = $this->getAll();
		$categories = $this->buildTree($dbCategories, $fromId);
		
		return $categories;
	}
	
	public function getOneById($id) {
	
		$query = <<<EOT
			SELECT c.id AS category_id, c.name AS category_name, c.parentid AS category_parentid
			FROM `category` AS c
			WHERE c.id = :id1 OR c.parentid = :id2
			; 
EOT;

		$pdoStatement = $this->db->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
		$pdoStatement->bindParam(':id1', $id, \PDO::PARAM_INT);
		$pdoStatement->bindParam(':id2', $id, \PDO::PARAM_INT);

		$collection = $this->buildTree($pdoStatement);
		
		return (reset($collection));
	}
	
	public function replaceParentId($oldId, $newId) {
		
			$query = <<<EOT
				UPDATE `category`
				SET parentid = :new_parent_id
				WHERE parentid = :old_parent_id
				; 
			;
EOT;
			$pdoStatement = $this->db->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$pdoStatement->bindParam(':old_parent_id', $oldId, \PDO::PARAM_INT);
			$pdoStatement->bindParam(':new_parent_id', $newId, \PDO::PARAM_INT);
			$pdoStatement->execute();
			
			return;
	}

	public function delete($id) {
		
		$query = <<<EOT
			DELETE
			FROM `category`
			WHERE id = :id
			; 
EOT;

		$pdoStatement = $this->db->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
		$pdoStatement->bindParam(':id', $id, \PDO::PARAM_INT);
		$pdoStatement->execute();
	}
	
	// store new category data to db
	public function insert($data) {
	
		if ($data['parentid'] == 0) { $data['parentid'] = null; }
		$prepared = $this->initInsert($data);
				
		// run insert
		$report = $this->putDataInDb($prepared);
		$data['id'] = $this->db->lastInsertId(); 
		$report['categoryId'] = $data['id'];
		
		return ($report);
	}
	
	// modify existing museum data in db
	public function update($data) {
	
		if ($data['parentid'] == 0) { $data['parentid'] = null; }
		$prepared = $this->initUpdate($data);
			
		// run query
		$report = $this->putDataInDb($prepared);
		$report['categoryId'] = $data['id'];
		
		return $report;
	}	
	
	// execute a query of update or insert
	private function putDataInDb(\PDOStatement $prepared) {
	
		$report = array();
		$report['hasError'] = false;

		try {
			$prepared->execute();
		} catch (\PDOException $e) {
			// handle errors coming form db insertion
			$report['hasError'] = true;
			if ($e->errorInfo[0] == 23000 && strstr($e->errorInfo[2],'category_parent')) {
				$report['errors']['parentid'][] = "Impossible d’assigner cette catégorie";
			} elseif ($e->errorInfo[0] == 23000 && strstr($e->errorInfo[2],'name')) {
				$report['errors']['name'][] = "Une catégorie sœur existe déjà avec ce nom";
			} else {
				$report['errors']['name'][] = "L’insertion de la catégorie est refusée pour une raison inconnue";
			}
		}
		
		return $report;		
	}
		
}
