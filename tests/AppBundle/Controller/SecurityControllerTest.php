<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form    = $crawler->filter('[type="submit"]')->form();

        $form['_username'] = 'testuser';
        $form['_password'] = 'testpass';

        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertGreaterThan(0, $crawler->filter('.alert.alert-danger')->count());

    }
}
