<?php

namespace Mesour\DropDownTests;

use Mesour\Components\RandomString\CapturingRandomStringGenerator;
use Mesour\Components\RandomString\IRandomStringGenerator;
use Mesour\DropDownTests\MockRandomStrings\DefaultTestRandomString;
use Tester\TestCase;

class BaseTestCase extends TestCase
{

	protected $generateRandomString = false;

	/**
	 * @var IRandomStringGenerator|CapturingRandomStringGenerator
	 */
	protected $randomStringGenerator;

	protected function createApplication()
	{
		$app = new \Mesour\UI\Application;
		$app->setRequest([]);
		$app->getContext()->setService($this->randomStringGenerator, IRandomStringGenerator::class);
		return $app;
	}

	public function setUp()
	{
		parent::setUp();

		if ($this->generateRandomString) {
			$this->randomStringGenerator = new CapturingRandomStringGenerator();
		} else {
			$this->randomStringGenerator = new DefaultTestRandomString();
		}
	}

	public function tearDown()
	{
		parent::tearDown();

		if ($this->generateRandomString) {
			$this->randomStringGenerator->writeToPhpFile(
				__DIR__ . '/MockRandomStrings/DefaultTestRandomString.php',
				DefaultTestRandomString::class
			);
		}
	}

}
