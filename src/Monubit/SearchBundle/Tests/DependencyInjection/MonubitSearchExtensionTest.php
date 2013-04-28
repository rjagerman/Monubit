<?php

namespace Monubit\SearchBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\SearchBundle\DependencyInjection\MonubitSearchExtension;

class MonubitSearchExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitSearchExtension();

		$extension->load(array(), $container);

	}

}
