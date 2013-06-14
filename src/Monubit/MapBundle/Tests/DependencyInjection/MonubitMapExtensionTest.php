<?php

namespace Monubit\MapBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\MapBundle\DependencyInjection\MonubitMapExtension;

class MonubitMapExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitMapExtension();

		$extension->load(array(), $container);

	}

}