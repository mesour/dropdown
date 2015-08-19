<?php
/**
 * This file is part of the Mesour Button (http://components.mesour.com/component/button)
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
class Item extends Button
{
    public function __construct($name = NULL, Components\IContainer $parent = NULL)
    {
        parent::__construct($name, $parent);
        $this->option[self::WRAPPER]['attributes']['class'] = FALSE;
        $this->option[self::WRAPPER]['attributes']['role'] = 'menuitem';
        $this->option[self::WRAPPER]['attributes']['tabindex'] = '-1';
    }

}
