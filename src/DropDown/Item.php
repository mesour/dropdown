<?php
/**
 * Mesour component - DropDown
 *
 * @license LGPL-3.0 and BSD-3-Clause
 * @copyright (c) 2015 Matous Nemec <http://mesour.com>
 */

namespace Mesour\DropDown;

use Mesour\Components;
use Mesour\UI\Button;

/**
 * @author mesour <http://mesour.com>
 * @package Mesour component - DropDown
 */
class Item extends Button
{
    public function __construct($name = NULL, Components\IComponent $parent = NULL)
    {
        parent::__construct($name, $parent);
        $this->option[self::WRAPPER]['attributes']['class'] = FALSE;
        $this->option[self::WRAPPER]['attributes']['role'] = 'menuitem';
        $this->option[self::WRAPPER]['attributes']['tabindex'] = '-1';
    }

}
