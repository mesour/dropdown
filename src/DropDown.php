<?php
/**
 * Mesour component - DropDown
 *
 * @license LGPL-3.0 and BSD-3-Clause
 * @copyright (c) 2015 Matous Nemec <http://mesour.com>
 */

namespace Mesour\UI;

use Mesour\Components;
use Mesour\DropDown\Item;
use Mesour\DropDown\MainButton;

/**
 * @author mesour <http://mesour.com>
 * @package Mesour component - DropDown
 */
class DropDown extends Control
{
    const WRAPPER = 'wrapper',
        CARET = 'caret',
        DEFAULTS = 'defaults',
        MENU = 'menu',
        MENU_ITEM = 'menu_item',
        ITEMS = 'items',
        ICON = 'icon';

    /**
     * @var Components\Html
     */
    private $wrapper;

    /**
     * @var Components\Html
     */
    private $menu;

    private $items = array();

    public $onRender = array();

    private $option = array();

    static public $defaults = array(
        self::CARET => '&nbsp;<span class="caret"></span>',
        self::WRAPPER => array(
            'el' => 'div',
            'attributes' => array(
                'class' => 'dropdown',
            )
        ),
        self::MENU => array(
            'el' => 'ul',
            'attributes' => array(
                'class' => 'dropdown-menu',
                'role' => 'menu'
            )
        ),
        self::MENU_ITEM => array(
            'el' => 'li',
            'attributes' => array(
                'role' => 'presentation'
            )
        ),
        self::ITEMS => array(
            'header_class' => 'dropdown-header',
            'button_class' => '',
            'divider_class' => 'divider'
        ),
        self::DEFAULTS => array()
    );

    public function __construct($name = NULL, Components\IComponent $parent = NULL)
    {
        parent::__construct($name, $parent);
        $this->option = self::$defaults;
        $this['mainButton'] = new MainButton;
    }

    /**
     * @return Components\Html
     */
    public function getControlPrototype()
    {
        return !$this->wrapper ? ($this->wrapper = Components\Html::el($this->option[self::WRAPPER]['el'])) : $this->wrapper;
    }

    /**
     * @return Components\Html
     */
    public function getMenuPrototype()
    {
        return !$this->menu ? ($this->menu = Components\Html::el($this->option[self::MENU]['el'])) : $this->menu;
    }

    /**
     * @return Components\Html
     */
    protected function getMenuItemPrototype()
    {
        return Components\Html::el($this->option[self::MENU_ITEM]['el'], $this->option[self::MENU_ITEM]['attributes']);
    }

    /**
     * @param $text
     * @param array $attributes
     * @return Components\Html
     */
    public function addHeader($text, array $attributes = array())
    {
        $item = $this->getMenuItemPrototype();
        $class = $this->option[self::ITEMS]['header_class'];
        if (isset($attributes['class'])) {
            $class .= ' ' . $attributes['class'];
            unset($attributes['class']);
        }
        $item->class($class);
        $item->setText($this->getTranslator()->translate($text));
        $item->addAttributes($attributes);

        $this->items[] = $item;
        return $item;
    }

    /**
     * @param array $attributes
     * @return Components\Html
     */
    public function addDivider(array $attributes = array())
    {
        $item = $this->getMenuItemPrototype();
        $class = $this->option[self::ITEMS]['divider_class'];
        if (isset($attributes['class'])) {
            $class .= ' ' . $attributes['class'];
            unset($attributes['class']);
        }
        $item->class($class);
        $item->addAttributes($attributes);

        $this->items[] = $item;
        return $item;
    }

    public function addButton($text = NULL)
    {
        $button = new Item;
        $button->setText($text);
        return $this->items[] = $button;
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return MainButton
     */
    public function getMainButton()
    {
        return $this['mainButton'];
    }

    public function create($data = array())
    {
        parent::create();

        $id = uniqid();

        $option_data = $this->option[self::DEFAULTS];
        $wrapper = $this->getControlPrototype();
        $this->wrapper = clone $wrapper;
        $menu = $this->getMenuPrototype();
        $this->menu = clone $menu;

        $this->onRender($this, $data);

        foreach ($this->option[self::WRAPPER]['attributes'] as $key => $value) {
            if (!$this->wrapper->{$key} && $this->wrapper->{$key} !== FALSE) {
                $this->wrapper->{$key}(trim(Components\Helper::parseValue($value, $option_data)));
            }
        }

        $main = $this->getMainButton();

        $main->setAttribute('id', $id);

        $this->wrapper->add($main->create($data)->add($this->option[self::CARET]));

        foreach ($this->option[self::MENU]['attributes'] as $key => $value) {
            if (!$this->menu->{$key}) {
                $this->menu->{$key}(Components\Helper::parseValue($value, $option_data));
            }
        }
        $this->menu->addAttributes(array('aria-labelledby' => $id));

        foreach ($this->items as $item) {
            if ($item instanceof Item) {
                $_item = $this->getMenuItemPrototype();
                $_item->class($this->option[self::ITEMS]['button_class']);
                $_item->add($item->create($data));
                $this->menu->add($_item);
            } else {
                $this->menu->add($item);
            }
        }

        $this->wrapper->add($this->menu);

        $out = $this->wrapper;
        $this->menu = $menu;
        $this->wrapper = $wrapper;
        return $out;
    }

}
