<?php

/**
 * Controller class for dev specific actions
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace Museo\Controller;

use Museo\Lib\Controller;

class DevController extends controller
{
	// initialise all data to get db schema and some sample
	function initAction() {

		session_unset();

		$req=file_get_contents ("../Museo/Model/sql/schema.sql", FILE_TEXT);
		$this->db->exec($req);

		$req=file_get_contents ("../Museo/Model/sql/sampleData.sql", FILE_TEXT);
		$this->db->exec($req);

	}

}
