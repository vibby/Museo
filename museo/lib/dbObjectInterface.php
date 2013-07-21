<?php

/**
 * Interface to ensure db object and db object managers ensure some requirements
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace museo\lib;

interface dbObjectInterface
{
	static function getTableName();
	static function getFields();
	
}
