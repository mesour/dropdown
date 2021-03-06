<?php

namespace Mesour\DropDownTests;

use Mesour\Components\Security\IAuthorizator;
use Mesour\Components\Security\Permission;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/MockRandomStrings/DefaultTestRandomString.php';

class EnabledSomeTest extends BaseTestCase
{

	public function testDefault()
	{
		$application = $this->createApplication();

		/** @var IAuthorizator|Permission $auth */
		$auth = new Permission();
		$application->getContext()->setService($auth, IAuthorizator::class);

		$auth->addRole('guest');
		$auth->addRole('registered', 'guest');

		$auth->addResource('menu');

		$auth->allow('guest', 'menu', ['first', 'second']);
		$auth->allow('registered', 'menu');
		$auth->deny('registered', 'menu', 'second');

		$application->setUserRole('registered');

		$dropDown = new \Mesour\UI\DropDown('testDropDown0', $application);

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setPermission('menu', 'second')
			->setAttribute('href', $dropDown->link('/first/'));

		$dropDown->addDivider();

		$dropDown->addHeader('Test header 2');

		$dropDown->addButton()
			->setText('Second button')
			->setConfirm('Test confirm :-)')
			->setAttribute('href', $dropDown->link('/second/'));

		$dropDown->addButton()
			->setText('Third button')
			->setPermission('menu', 'second')
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
			->setPermission('menu', 'second')
			->setAttribute('href', $dropDown->link('/third/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Actions (enabled some)')
			->setType('danger');

		Assert::same(
			file_get_contents(__DIR__ . '/data/EnabledSomeTestOutput.html'),
			(string) $dropDown->render(),
			'Output of dropdown render doest not match'
		);
	}

}

$test = new EnabledSomeTest();
$test->run();
