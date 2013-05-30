<?php

namespace Monubit\RatingsBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\RatingsBundle\DependencyInjection\MonubitRatingsExtension;

class MonubitRatingsExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitRatingsExtension();

		$extension->load(array(), $container);

	}

}