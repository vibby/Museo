<?php

/**
 * A manager to handle project objects
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace Museo\Lib;

class objectManager
{
	protected $db = null;

	public function __construct(\PDO $db = null) {
		$this->db = $db;
	}

	// sanitize data (to run before creating object)
	public function sanitizeData($data) {
		
		$filters = $this->getFilters();

		// verify that only accepted data are coming
		$unwantedData = array_diff_key($data, $filters);
		if (!empty($unwantedData)) {
			throw new \exception("Object sanitization failed because of extra parameter(s)");
		}

		// sanitize data
		$data = filter_var_array($data, $filters);
		
		return $data;
	}
	
	// prepare the query to insert the created object
	public function initInsert($data) {
	
		$query = "INSERT INTO `".$this->getTableName()."` SET ";
		$i = 0;
		$directFields = array_intersect(array_keys($this->getFilters()), $this->getFields());
		unset ($directFields[array_search('id',$directFields)]);
		foreach ($directFields as $fieldName) {
			if ($i) { $query .= ", "; }
			$query .= $fieldName . " = :param" . $i ;
			$i++;
		}
		$prepared = $this->db->prepare($query);
		$i = 0;
		foreach ($directFields as $fieldName) {
			$prepared->bindParam(":param" . $i, $data[$fieldName]);
			$i++;
		}
		
		return $prepared;
	}
	
	// prepare the query to update the modified object
	public function initUpdate($data) {
	
		$query = "UPDATE `".$this->getTableName()."` SET ";
		$i = 0;
		$directFields = array_intersect(array_keys($this->getFilters()), $this->getFields());
		unset ($directFields[array_search('id',$directFields)]);
		foreach ($directFields as $fieldName) {
			if ($i) { $query .= ", "; }
			$query .= $fieldName . " = :param" . $i ;
			$i++;
		}
		$query .= " WHERE id = :id ";
		
		// prepare query
		$prepared = $this->db->prepare($query);
		$i = 0;
		foreach ($directFields as $fieldName) {
			$prepared->bindParam(":param" . $i, $data[$fieldName]);
			$i++;
		}
		$prepared->bindParam(":id", $data['id'], \PDO::PARAM_INT);
		
		return $prepared;
	}
	
}
