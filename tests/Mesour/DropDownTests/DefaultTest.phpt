<?php

namespace Mesour\DropDownTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/MockRandomStrings/DefaultTestRandomString.php';

class DefaultTest extends BaseTestCase
{

	protected $generateRandomString = false;

	public function testDefault()
	{
		$container = new \Mesour\UI\Control;

		$dropDown = new \Mesour\UI\DropDown('testDropDown', $container);

		$dropDown->setRandomStringGenerator($this->randomStringGenerator);

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setAttribute('href', $dropDown->link('/first/'));

		$dropDown->addDivider();

		$dropDown->addHeader('Test header 2');

		$dropDown->addButton()
			->setText('Second button')
			->setConfirm('Test confirm :-)')
			->setAttribute('href', $dropDown->link('/second/'));

		$dropDown->addButton()
			->setText('Third button')
			->setAttribute('href', $dropDown->link('/third/'));

		$dropDown->addDivider();

		$dropDown->addHeader('Test header 3');

		$dropDown->addButton()
			->setText('Fourth button')
			->setAttribute('href', $dropDown->link('/third/'));

		$dropDown->addButton()
			->setText('Fifth button')
			->setConfirm('Test confirm :-)')
			->setAttribute('href', $dropDown->link('/second/'));

		$dropDown->addButton()
			->setText('Sixth button')
			->setAttribute('href', $dropDown->link('/third/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Actions (enabled all)')
			->setType('danger')
			->setIcon();

		Assert::same(
			file_get_contents(__DIR__ . '/data/DefaultTestOutput.html'),
			(string) $dropDown->render(),
			'Output of dropdown render doest not match'
		);
	}

}

$test = new DefaultTest();
$test->run();
