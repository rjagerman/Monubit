<?php

namespace Monubit\UserBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\UserBundle\DependencyInjection\MonubitUserExtension;

class MonubitUserExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitUserExtension();

		$extension->load(array(), $container);

	}

}