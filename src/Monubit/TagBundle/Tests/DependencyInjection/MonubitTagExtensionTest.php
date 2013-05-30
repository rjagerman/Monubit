<?php

namespace Monubit\TagBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\TagBundle\DependencyInjection\MonubitTagExtension;

class MonubitTagExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitTagExtension();

		$extension->load(array(), $container);

	}

}
