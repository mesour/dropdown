<?php

namespace Mesour\DropDownTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/MockRandomStrings/DefaultTestRandomString.php';

class DisabledTest extends BaseTestCase
{

	public function testDefault()
	{
		$container = new \Mesour\UI\Control;

		$dropDown = new \Mesour\UI\DropDown('testDropDown3', $container);

		$dropDown->setRandomStringGenerator($this->randomStringGenerator);

		$dropDown->setDisabled();

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setAttribute('href', $dropDown->link('/first/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Disabled by default')
			->setType('warning');

		Assert::same(
			file_get_contents(__DIR__ . '/data/DisabledTestOutput.html'),
			(string) $dropDown->render(),
			'Output of dropdown render doest not match'
		);
	}

}

$test = new DisabledTest();
$test->run();
