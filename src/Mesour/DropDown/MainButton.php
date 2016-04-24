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
class MainButton extends Mesour\UI\Button
{

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		$this->defaults[self::WRAPPER]['el'] = 'button';
		$this->defaults[self::WRAPPER]['attributes']['data-toggle'] = 'dropdown';

		parent::__construct($name, $parent);
	}

}
