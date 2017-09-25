<?php

namespace Mesour\DropDownTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/MockRandomStrings/DefaultTestRandomString.php';

class PullRightTest extends BaseTestCase
{

	public function testDefault()
	{
		$container = $this->createApplication();

		$dropDown = new \Mesour\UI\DropDown('testDropDown4', $container);

		$dropDown->getControlPrototype()
			->style('float:right;');

		$dropDown->setPullRight();

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setAttribute('href', $dropDown->link('/first/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Pull right')
			->setType('warning');

		Assert::same(
			file_get_contents(__DIR__ . '/data/PullRightTestOutput.html'),
			(string) $dropDown->render(),
			'Output of dropdown render doest not match'
		);
	}

}

$test = new PullRightTest();
$test->run();
