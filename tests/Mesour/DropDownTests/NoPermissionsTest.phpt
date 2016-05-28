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
		$application = $this->createApplication();

		$application->getUser()->setRoles('registered');

		$dropDown = new \Mesour\UI\DropDown('testDropDown2', $application);

		$auth = $dropDown->getAuthorizator();

		$auth->addRole('guest');
		$auth->addRole('registered', 'guest');

		$auth->addResource('menu');

		$auth->allow('guest', 'menu', ['first', 'second']);
		$auth->allow('registered', 'menu');
		$auth->deny('registered', 'menu', 'second');

		$dropDown->setRandomStringGenerator($this->randomStringGenerator);

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$firstButton = $first->setText('First button');
		$firstButton->setPermission('menu', 'second');
		$firstButton->setAttribute('href', $dropDown->link('/first/'));

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
