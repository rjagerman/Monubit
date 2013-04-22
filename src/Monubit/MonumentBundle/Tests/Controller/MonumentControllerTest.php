<?php

namespace Monubit\MonumentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MonumentControllerTest extends WebTestCase
{
    public function testMonument()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/monument/2');

        $this->assertTrue($crawler->filter('html:contains("Monument")')->count() > 0);
    }
}
