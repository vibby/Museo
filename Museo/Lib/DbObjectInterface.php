<?php

/**
 * Interface to ensure db object and db object managers ensure some requirements
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */

namespace Museo\Lib;

interface DbObjectInterface
{
	static function getTableName();
	static function getFields();
	
}
