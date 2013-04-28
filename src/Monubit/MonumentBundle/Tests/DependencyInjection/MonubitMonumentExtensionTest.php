<?php

namespace Monubit\MonumentBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\MonumentBundle\DependencyInjection\MonubitMonumentExtension;

class MonubitMonumentExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitMonumentExtension();

		$extension->load(array(), $container);

	}

}
