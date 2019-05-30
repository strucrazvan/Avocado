<?php

namespace ConferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProposalControllerTest extends WebTestCase
{
    public function testAddproposal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addProposal');
    }

    public function testGetproposalbyid()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProposalById');
    }

    public function testGetproposals()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProposals');
    }

}
