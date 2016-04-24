<?php
/**
 * This file is part of the Mesour DropDown (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DropDown\RandomString;

use Mesour;

/**
 * @author Matouš Němec (http://mesour.com)
 */
class MockRandomStringGenerator implements IRandomStringGenerator
{

	private $current = 0;

	protected $values = [];

	public function generate()
	{
		if (!isset($this->values[$this->current])) {
			throw new Mesour\OutOfRangeException('Trying to get random string out of range.');
		}
		$out = $this->values[$this->current];
		$this->current++;
		return $out;
	}

}
