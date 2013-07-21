<?php

namespace museo;

class config {

	function __construct() {
		$this->config = array(	
			'dbHost'     => 'localhost',
			'dbName'     => 'museo',
			'dbUser'     => 'root',
			'dbPassword' => '',
			
			'debug'      => true,
		);
	}
	
	function get($key) {
		return $this->config[$key];
	}
}
