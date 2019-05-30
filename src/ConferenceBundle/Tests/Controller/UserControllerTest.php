<?php

namespace ConferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testAddnewuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addNewUser');
    }

    public function testGetuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getUser');
    }

}
