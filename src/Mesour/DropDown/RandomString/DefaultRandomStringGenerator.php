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
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class DefaultRandomStringGenerator implements IRandomStringGenerator
{

	public function generate()
	{
		return uniqid();
	}

}
