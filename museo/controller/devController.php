<?php

/**
 * Controller class for dev specific actions
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace museo\controller;

use museo\lib\controller;

class devController extends controller
{
	// initialise all data to get db schema and some sample
	function initAction() {

		session_unset();
	
		$req=file_get_contents ("../museo/model/sql/schema.sql", FILE_TEXT);
		$this->db->exec($req);

		$req=file_get_contents ("../museo/model/sql/sampleData.sql", FILE_TEXT);
		$this->db->exec($req);
		
	}

}
