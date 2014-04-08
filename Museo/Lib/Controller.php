<?php

/**
 * Base controller class
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace Museo\Lib;

use Museo\Config;
use Museo\Lib\ConnexionManager;

class Controller
{
	protected $db;
	protected $config;

	// before any actions launch
    public function __construct() {

		$this->config = new Config;
		session_start();

		// here is "debug mode"
		if ($this->config->get('debug') === true) {
			error_reporting(E_ALL | E_STRICT);
		}

		$this->initDb();

    }

	// initialize db connexion and configuration
    public function initDb() {

		// connect db
		$dbConnection = new connexionManager(
			$this->config->get('dbHost'),
			$this->config->get('dbName'),
			$this->config->get('dbUser'),
			$this->config->get('dbPassword')
		);

		// force PDO to really prepare requests
		$dbConnection->connexion->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		$dbConnection->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		$this->db = $dbConnection->connexion;
    }

	// Generate a token to verify that a form comes back from where it was sent
	protected function generateCrsf($sessionNamePrefix) {

		$rand = md5(mt_rand());
		$_SESSION[$sessionNamePrefix.'_token'] = $rand;

		return $rand;
	}

	// Check the form token
	protected function checkCrsf($sessionNamePrefix) {

		if (!array_key_exists('token',$_POST) ||
				!array_key_exists($sessionNamePrefix.'_token',$_SESSION) ||
				$_POST['token'] != $_SESSION[$sessionNamePrefix.'_token']) {
			header('HTTP/1.1 417 Token validation failure');
			throw new \exception("Form submission failed at token validation");
		}
	}

	// get a required parameter from request or stop execution on a 417 status code error
	protected function requireParam($paramName, $validator) {

		$param = $this->getParam($paramName, $validator);
		if (is_null($param)) {
			header('HTTP/1.1 417 Required parameter unfurnished');
			throw new \exception("Query parameter error");
		}
		return $param;
	}

	// get an optional parameter from request
	protected function getParam($paramName, $validator) {

		if (!array_key_exists($paramName, $_REQUEST) || !filter_var($_REQUEST[$paramName],$validator)) {
			return null;
		}
		return $_REQUEST[$paramName];
	}

	// common initialisation of the treatment of form
	protected function initTreatForm($sessionNamePrefix) {

		// Only POST method is accepted
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			throw new \exception('Form submission cannot be reached in non-post method');
		}

		// Verify token
		$this->checkCrsf($sessionNamePrefix);
	}

	// common initialisation of a "new object" form
	protected function initNewAction($sessionNamePrefix) {

		// get data from an eventual previous sent but failed attempt
		$data = array_key_exists($sessionNamePrefix . '_data',$_SESSION) ?
			$_SESSION[$sessionNamePrefix.'_data'] :
			array();
		// get eventual errors to show at each field
		$errors = array_key_exists($sessionNamePrefix . '_errors',$_SESSION) ?
			$_SESSION[$sessionNamePrefix.'_errors'] :
			array();

		// errors and data are shown once only
		unset ($_SESSION[$sessionNamePrefix.'_data']);
		unset ($_SESSION[$sessionNamePrefix.'_errors']);

		return array($data, $errors);
	}

	// common initialisation of a "edit object" form
	protected function initEditAction($sessionNamePrefix) {

		if (array_key_exists($sessionNamePrefix . '_data',$_SESSION)) {
			// get data from an eventual previous sent but failed attempt
			$data = $_SESSION[$sessionNamePrefix . '_data'];
		} else {
			// get data from id in GET parameter
			$data = $this->getOneById()->toArray();
		}

		// get eventual errors to show at each field
		$errors = array_key_exists($sessionNamePrefix.'_errors',$_SESSION) ?
			$_SESSION[$sessionNamePrefix.'_errors'] :
			array();

		// errors and data are shown once only
		unset ($_SESSION[$sessionNamePrefix.'_data']);
		unset ($_SESSION[$sessionNamePrefix.'_errors']);

		return array($data, $errors);
	}
}
