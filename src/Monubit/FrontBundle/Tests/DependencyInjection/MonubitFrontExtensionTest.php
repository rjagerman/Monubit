<?php

namespace Monubit\FrontBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\FrontBundle\DependencyInjection\MonubitFrontExtension;

class MonubitFrontExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitFrontExtension();

		$extension->load(array(), $container);

	}

}
