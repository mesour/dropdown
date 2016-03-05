<?php
/**
 * This file is part of the Mesour DropDown (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\UI;

use Mesour;

/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 *
 * @method null onRender(DropDown $dropDown)
 * @method Mesour\Components\Control\IControl current()
 */
class DropDown extends Mesour\Components\Control\AttributesControl
{

	const WRAPPER = 'wrapper',
		CARET = 'caret',
		DEFAULTS = 'defaults',
		MENU = 'menu',
		MENU_ITEM = 'menu_item',
		ITEMS = 'items';

	/**
	 * @var Mesour\Components\Utils\Html
	 */
	private $menu;

	private $disabled = false;

	protected $hasPullRight = false;

	private $items = [];

	public $onRender = [];

	protected $defaults = [
		self::CARET => '&nbsp;<span class="caret"></span>',
		self::WRAPPER => [
			'el' => 'div',
			'attributes' => [
				'class' => 'dropdown',
			],
		],
		self::MENU => [
			'el' => 'ul',
			'attributes' => [
				'class' => 'dropdown-menu',
				'role' => 'menu',
			],
		],
		self::MENU_ITEM => [
			'el' => 'li',
			'attributes' => [
				'role' => 'presentation',
			],
		],
		self::ITEMS => [
			'header_class' => 'dropdown-header',
			'button_class' => '',
			'divider_class' => 'divider',
		],
		self::DEFAULTS => [],
	];

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		parent::__construct($name, $parent);

		$this['mainButton'] = new Mesour\DropDown\MainButton();

		$this->setHtmlElement(Mesour\Components\Utils\Html::el(
			$this->getOption(self::WRAPPER, 'el'),
			$this->getOption(self::WRAPPER, 'attributes')
		));

		$this->addComponent(new Control, 'items');
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getControlPrototype()
	{
		return $this->getHtmlElement();
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getMenuPrototype()
	{
		return !$this->menu
			? ($this->menu = Mesour\Components\Utils\Html::el($this->getOption(self::MENU, 'el')))
			: $this->menu;
	}

	public function setDisabled($disabled = true)
	{
		$this->disabled = (bool)$disabled;
		return $this;
	}

	public function setPullRight($hasPullRight = true)
	{
		$this->hasPullRight = (bool)$hasPullRight;
		return $this;
	}

	public function isDisabled()
	{
		return $this->disabled;
	}

	/**
	 * @param $text
	 * @param array $attributes
	 * @return Mesour\Components\Utils\Html
	 */
	public function addHeader($text, array $attributes = [])
	{
		$item = $this->getMenuItemPrototype();
		$class = $this->getOption(self::ITEMS, 'header_class');
		if (isset($attributes['class'])) {
			$class .= ' ' . $attributes['class'];
			unset($attributes['class']);
		}
		$item->class($class);
		$item->setText($this->getTranslator()->translate($text));
		$item->addAttributes($attributes);

		$this->items[$this->getItemsCount() + 1] = $item;
		return $item;
	}

	/**
	 * @param array $attributes
	 * @return Mesour\Components\Utils\Html
	 */
	public function addDivider(array $attributes = [])
	{
		$item = $this->getMenuItemPrototype();
		$class = $this->getOption(self::ITEMS, 'divider_class');
		if (isset($attributes['class'])) {
			$class .= ' ' . $attributes['class'];
			unset($attributes['class']);
		}
		$item->class($class);
		$item->addAttributes($attributes);

		$this->items[$this->getItemsCount() + 1] = $item;
		return $item;
	}

	public function addButton($text = null)
	{
		$button = new Mesour\DropDown\Item;
		$button->setText($text);
		return $this['items'][$this->getItemsCount() + 1] = $button;
	}

	protected function getItemsCount()
	{
		return count($this->items) + count($this['items']);
	}

	/**
	 * @return Mesour\DropDown\Item[]
	 */
	public function getItems()
	{
		$out = [];

		$count = $this->getItemsCount();
		for ($i = 1; $i <= $count; $i++) {
			if (isset($this->items[$i])) {
				$out[] = $this->items[$i];
			} elseif (isset($this['items'][$i])) {
				$out[] = $this['items'][$i];
			}
		}
		return $out;
	}

	/**
	 * @return Mesour\DropDown\MainButton
	 */
	public function getMainButton()
	{
		return $this['mainButton'];
	}

	public function create()
	{
		parent::create();

		$id = uniqid();

		$wrapper = $this->getControlPrototype();
		$oldWrapper = clone $wrapper;
		$menu = $this->getMenuPrototype();
		$oldMenu = clone $menu;

		$this->onRender($this);

		$optionData = $this->getOption(self::DEFAULTS);

		foreach ($this->getOption(self::WRAPPER, 'attributes') as $key => $value) {
			if (!$wrapper->{$key} && $wrapper->{$key} !== false) {
				$menu->addAttributes([$key => trim(Mesour\Components\Utils\Helpers::parseValue($value, $optionData))]);
			}
		}

		$main = $this->getMainButton();
		$main->setOption('data', $this->getOption('data'));

		$main->setAttribute('id', $id);

		foreach ($this->getOption(self::MENU, 'attributes') as $key => $value) {
			if (!$menu->{$key}) {
				$menu->addAttributes([$key => Mesour\Components\Utils\Helpers::parseValue($value, $optionData)]);
			}
		}
		$menu->addAttributes(['aria-labelledby' => $id]);
		if ($this->hasPullRight) {
			$menu->addAttributes(['class' => $menu->class . ' dropdown-menu-right']);
		}

		if (!$this->isDisabled()) {
			$isFirst = true;
			$items = $this->getItems();
			foreach ($items as $key => $item) {
				if ($item instanceof Mesour\DropDown\Item) {
					if (!$item->isAllowed()) {
						continue;
					}
					$item->setOption('data', $this->getOption('data'));
					$_item = $this->getMenuItemPrototype();
					$_item->class($this->getOption(self::ITEMS, 'button_class'));
					$_item->add($item->create());
					$menu->add($_item);
					$isFirst = false;
				} else {
					$isNext = false;
					if (isset($items[$key + 1]) && $isNext = $this->isSomeNext($items, $key + 1)) {
						$menu->add($item);
						$isFirst = false;
					}
					if (
						!$isNext
						&& ($this->isDivider($items[$key]) && !$isFirst)
						&& $this->isHeader($items[$key + 1])
						&& (isset($items[$key + 2]) && $this->isSomeNext($items, $key + 2))
					) {
						$menu->add($item);
						$isFirst = false;
					}

				}
			}
			if ($isFirst) {
				$main->setDisabled();
			}
		} else {
			$main->setDisabled();
		}

		$wrapper->add($main->create()->add($this->getOption(self::CARET)));

		$wrapper->add($menu);

		$out = $wrapper;

		$this->menu = $oldMenu;
		$this->setHtmlElement($oldWrapper);

		return $out;
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	protected function getMenuItemPrototype()
	{
		return Mesour\Components\Utils\Html::el(
			$this->getOption(self::MENU_ITEM, 'el'),
			$this->getOption(self::MENU_ITEM, 'attributes')
		);
	}

	protected function isDivider($item)
	{
		return isset($item->class) && strpos($item->class, 'divider') !== false;
	}

	protected function isHeader($item)
	{
		return !$this->isDivider($item) && !$this->isLink($item);
	}

	protected function isLink($item)
	{
		return $item instanceof Mesour\DropDown\Item;
	}

	protected function isActiveLink($item)
	{
		/** @var Mesour\DropDown\Item $item */
		return $this->isLink($item) && $item->isAllowed();
	}

	protected function isSomeNext($items, $currentKey)
	{
		for ($i = $currentKey; $i < count($items); $i++) {
			if (!$this->isHeader($items[$i]) && !$this->isDivider($items[$i])) {
				if ($this->isActiveLink($items[$i])) {
					return true;
				}
			} else {
				return false;
			}
		}
		return false;
	}

}
