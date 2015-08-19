<?php
/**
 * This file is part of the Mesour DropDown (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DropDown;

use Mesour\Components;
use Mesour\UI\Button;

/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class MainButton extends Button
{
    public function __construct($name = NULL, Components\IContainer $parent = NULL)
    {
        parent::__construct($name, $parent);
        $this->option[self::WRAPPER]['el'] = 'button';
        $this->option[self::WRAPPER]['attributes']['data-toggle'] = 'dropdown';
    }

}
