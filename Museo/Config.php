<?php

namespace Museo;

class Config {

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
