<?php

/**
 * A manager to handle Museums objects
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace Museo\Model;

use Museo\Lib\ObjectManager;
use Museo\Lib\DbObjectInterface;

class MuseumManager extends ObjectManager implements DbObjectInterface
{

	// get the name of the table in db
	public static function getTableName() {
		return 'museum';
	}

	// get field in db
	static function getFields() {
		return array('id','name','description');
	}

	// define sanitizing filters
	protected static function getFilters() {
		return array(
			'name'         => FILTER_SANITIZE_STRING,
			'description'  => FILTER_SANITIZE_STRING,
			'categories'   => array(
									'filter' => FILTER_VALIDATE_INT,
									'flags'  => FILTER_REQUIRE_ARRAY,
								   ),
			'id'           => FILTER_VALIDATE_INT,
		);
	}

	// transform a PDO statement containing a db select query into a collection of Museum objects
	public function getCollection(\PDOStatement $pdoStatement) {

		$collection = array();
		$pdoStatement->execute();
		// for each line in db, instanciate an object
		foreach ($pdoStatement as $line) {
			// Do not instanciate many times the same museum (just add its category below)
			if (!array_key_exists($line['museum_id'],$collection)) {
				$collection[$line['museum_id']] = new Museum($line);
			}
			// add its category if there is one
			if (array_key_exists('category_id', $line) && !is_null($line['category_id'])) {
				$collection[$line['museum_id']]->addCategory(new Category($line));
			}
		}

		return $collection;
	}

	// Get all museum objects
	function getAll() {

		$query = <<<EOT
			SELECT mc.category_id, m.id AS museum_id, m.name AS museum_name, c.name AS category_name, c.parentid
			FROM `museum` AS m
			LEFT JOIN `museumcategory` AS mc ON m.id = mc.museum_id
			LEFT JOIN `category` AS c ON mc.category_id = c.id
			;
EOT;

		$pdoStatement = $this->db->query($query);
		$collection = $this->getCollection($pdoStatement);

		return ($collection);
	}

	// Get a museum object by its ID
	public function getOneById($id) {

		// define a query
		$query = <<<EOT
			SELECT mc.category_id, m.id AS museum_id, m.description AS museum_description, m.name AS museum_name, c.name AS category_name, c.parentid
			FROM `museum` AS m
			LEFT JOIN `museumcategory` AS mc ON m.id = mc.museum_id
			LEFT JOIN `category` AS c ON mc.category_id = c.id
			WHERE m.id = :id
			;
EOT;

		$pdoStatement = $this->db->prepare($query);
		$pdoStatement->bindParam(':id', $id, \PDO::PARAM_INT);

		$collection = $this->getCollection($pdoStatement);

		if (empty($collection)) {
			header('HTTP/1.1 404 Museum not found');
			throw new \exception("Ce musee n'existe pas (ou plus)"); }
		return reset($collection);
	}

	// Delete a museum
	function deleteOneById($id) {

		$query = <<<EOT
			DELETE
			FROM `museum`
			WHERE id = :id
			;
EOT;

		$pdoStatement = $this->db->prepare($query);

		$pdoStatement->bindParam(':id', $id, \PDO::PARAM_INT);
		$pdoStatement->execute();
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

		return $errors;
	}

	// store new museum data to db
	public function insert($data) {

		// prepare query to insert museum itself
		$prepared = $this->initInsert($data);

		// run insert
		$report = $this->putDataInDb($prepared);
		$data['id'] = $this->db->lastInsertId();
		$report['museumId'] = $data['id'];
		// create links between museum and categories
		$report2 = $this->createMuseumCategories($data);

		return array_merge($report, $report2);
	}

	// modify existing museum data in db
	public function update($data) {

		$prepared = $this->initUpdate($data);

		// run query
		$report = $this->putDataInDb($prepared);
		$report['museumId'] = $data['id'];

		// run query
		$report2 = $this->deleteMuseumCategories($data);
		$report3 = $this->createMuseumCategories($data);

		return array_merge($report, $report2, $report3);
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
			if ($e->errorInfo[0] == 23000) {
				$report['errors']['name'][] = "Un autre musée existe déjà avec ce nom";
			} else {
				$report['errors']['name'][] = "L'insertion du musée est refusée pour une raison inconnue";
			}
			return $report;
		}

		return $report;

	}

	// insert links between museum and categories
	private function createMuseumCategories($data) {

		$report = array();

		if (is_array($data['categories'])) {
			$query = "INSERT INTO `museumcategory` (museum_id, category_id) VALUES ";
			$i = 0;
			foreach ($data['categories'] as $categoryId) {
				if ($i) { $query .= ", "; }
				$query .= "(" . $data['id'] . ", " . $categoryId . ")" ;
				$i++;
			}

			$prepared = $this->db->prepare($query);
			try {
				$prepared->execute();
			} catch (\PDOException $e) {
				$report['warning']['categories'][] = "Erreur a la définition des categories";
			}
		}

		return $report;
	}

	// delete links between museum and categories
	private function deleteMuseumCategories($data) {

		$report = array();
		$query = "DELETE FROM museumcategory WHERE museum_id = :id ";
		$prepared = $this->db->prepare($query);
		$prepared->bindParam(":id", $data['id'], \PDO::PARAM_INT);

		try {
			$prepared->execute();
		} catch (\PDOException $e) {
			$report['warning']['categories'][] = "Erreur a la définition des categories";
		}

		return $report;
	}
}
