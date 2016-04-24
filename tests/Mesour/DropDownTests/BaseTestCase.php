<?php

namespace Mesour\DropDownTests;

use Mesour\DropDown\RandomString\CapturingRandomStringGenerator;
use Mesour\DropDown\RandomString\IRandomStringGenerator;
use Mesour\DropDownTests\MockRandomStrings\DefaultTestRandomString;
use Tester\TestCase;

class BaseTestCase extends TestCase
{

	protected $generateRandomString = false;

	/**
	 * @var IRandomStringGenerator|CapturingRandomStringGenerator
	 */
	protected $randomStringGenerator;

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
				'Mesour\DropDownTests\MockRandomStrings\DefaultTestRandomString'
			);
		}
	}

}
