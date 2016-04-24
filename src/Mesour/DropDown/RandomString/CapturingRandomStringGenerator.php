<?php
/**
 * This file is part of the Mesour DropDown (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DropDown\RandomString;

use Mesour;

/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class CapturingRandomStringGenerator implements IRandomStringGenerator
{

	private $randoms = [];

	public function generate()
	{
		return $this->randoms[] = uniqid();
	}

	public function writeToPhpFile($fileName, $className)
	{
		preg_match('#^(?:(.*)\\\\)?([^\\\\]+)\z#', $className, $match);
		list(, $namespace, $className) = $match;
		$code = '<?php' . "\n";
		$code .= "\n";
		if ($namespace) {
			$code .= 'namespace ' . $namespace . ';' . "\n";
			$code .= "\n";
		}
		$code .= 'use Mesour\DropDown\RandomString\MockRandomStringGenerator;' . "\n";
		$code .= "\n";
		$code .= 'class ' . $className . " extends MockRandomStringGenerator\n";
		$code .= '{' . "\n\n";

		$code .= "\t" . 'protected $values = [' . "\n";
		foreach ($this->randoms as $random) {
			$code .= sprintf("\t\t'%s',\n", $random);
		}
		$code .= "\t" . '];' . "\n\n";

		$code .= '}' . "\n";

		file_put_contents($fileName, $code);
	}

}
