<?php

namespace Monubit\RecommendationBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Monubit\RecommendationBundle\DependencyInjection\MonubitRecommendationExtension;

class MonubitRecommendationExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the loading of default configuration
	 */
	public function testLoad() {

		$container = new ContainerBuilder();
		$extension = new MonubitRecommendationExtension();

		$extension->load(array(), $container);

	}

}
