<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/01/2017
 * Time: 10:48
 */

namespace Test\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    protected $firstName;
    protected $lastName;
    protected $trustableEmail;
    protected $untrustableEmail;
    protected $badEmail;
    protected $plainPassword;

    public function setUp()
    {
        $this->firstName = "testFirstName";
        $this->lastName = "testLastName";
        $this->trustableEmail = "test@cs2i-lorient.fr";
        $this->untrustableEmail = "test@test.test";
        $this->badEmail = "notAnEmail";
        $this->plainPassword = "testPassword";
    }

    public function testInscription()
    {
        $client = static::createClient();
        $method = 'POST';
        $uri = '/addUser';
        $server = array(
            'CONTENT_TYPE' => 'application/json'
        );
        $content = json_encode(
            array(
                'firstname'     => $this->firstName,
                'lastname'      => $this->lastName,
                'plainPassword' => $this->plainPassword,
                'email'         => $this->trustableEmail
            )
        );
        $crawler = $client->request(
            $method,
            $uri,
            array(),
            array(),
            $server,
            $content,
            $changeHistory = true
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertContains(
            $this->firstName,
            $client->getResponse()->getContent()
        );
    }

    public function testAuthentification()
    {
        $client = static::createClient();
        $method = 'POST';
        $uri = '/auth-tokens';
        $server = array(
            'CONTENT_TYPE' => 'application/json'
        );
        $content = json_encode(
            array(
                'login'     => $this->trustableEmail,
                'password'  => $this->plainPassword
            )
        );
        $crawler = $client->request(
            $method,
            $uri,
            array(),
            array(),
            $server,
            $content,
            $changeHistory = true
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertContains(
            $this->firstName,
            $client->getResponse()->getContent()
        );
    }
}