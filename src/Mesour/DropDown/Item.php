<?php
/**
 * This file is part of the Mesour DropDown (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DropDown;

use Mesour;

/**
 * @author Matouš Němec (http://mesour.com)
 */
class Item extends Mesour\UI\Button
{

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		$this->defaults[self::WRAPPER]['attributes']['class'] = false;
		$this->defaults[self::WRAPPER]['attributes']['role'] = 'menuitem';
		$this->defaults[self::WRAPPER]['attributes']['tabindex'] = '-1';

		parent::__construct($name, $parent);
	}

}
