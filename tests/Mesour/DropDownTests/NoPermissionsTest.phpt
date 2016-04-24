<?php

namespace Mesour\DropDownTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/MockRandomStrings/DefaultTestRandomString.php';

class NoPermissionsTest extends BaseTestCase
{

	public function testDefault()
	{
		$container = new \Mesour\UI\Control;

		$auth = $container->getAuthorizator();

		$auth->addRole('guest');
		$auth->addRole('registered', 'guest');

		$auth->addResource('menu');

		$auth->allow('guest', 'menu', ['first', 'second']);
		$auth->allow('registered', 'menu');
		$auth->deny('registered', 'menu', 'second');

		$container->setUserRole('registered');

		$dropDown = new \Mesour\UI\DropDown('testDropDown2', $container);

		$dropDown->setRandomStringGenerator($this->randomStringGenerator);

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setPermission('menu', 'second')
			->setAttribute('href', $dropDown->link('/first/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Disabled (no link to use because haven\'t permissions)')
			->setType('primary');

		Assert::same(
			file_get_contents(__DIR__ . '/data/NoPermissionsTestOutput.html'),
			(string) $dropDown->render(),
			'Output of dropdown render doest not match'
		);
	}

}

$test = new NoPermissionsTest();
$test->run();
