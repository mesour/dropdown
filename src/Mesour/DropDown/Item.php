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
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class Item extends Mesour\UI\Button
{

    public function __construct($name = NULL, Mesour\Components\ComponentModel\IContainer $parent = NULL)
    {
        parent::__construct($name, $parent);

        $options = $this->getOption(self::WRAPPER);
        $options['attributes']['class'] = FALSE;
        $options['attributes']['role'] = 'menuitem';
        $options['attributes']['tabindex'] = '-1';
        $this->setOption(self::WRAPPER, $options);
    }

}
