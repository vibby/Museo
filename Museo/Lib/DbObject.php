<?php

/**
 * Base object class for all objects databased
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace Museo\Lib;

class DbObject
{
	function __construct($item) {
		// when an object is created, we need set in it all data from db
		foreach ($this->getFields() as $field) {
			if (array_key_exists($this->getTableName().'_'.$field, $item)) {
				$this->$field = $item[$this->getTableName().'_'.$field];
			}
		}		
	}
	
}
