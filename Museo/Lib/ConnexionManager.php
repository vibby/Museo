<?php

/**
 * Connexion manager lib
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace Museo\Lib;

class ConnexionManager{

	private $dbHost = null;
	private $dbName = null;
	private $dbUser = null;
	private $dbPassword = null;

	public $connexion = '';

	function __construct($dbHost, $dbName, $dbUser, $dbPassword){

		$this->dbHost = $dbHost;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->connect();
	}

	function connect(){

		try{
			$this->connexion = new \PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName."",$this->dbUser, $this->dbPassword);
			$this->connexion->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
		}catch(\PDOException $e){
			throw new \exception('We\'re sorry but there was an error while trying to connect to the database');
		}
	}
}
