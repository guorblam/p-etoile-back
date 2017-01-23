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
    protected $firstName = "";
    protected $lastName = "";
    protected $trustableEmail = "";
    protected $untrustableEmail = "";
    protected $badEmail = "";
    protected $plainPassword = "";

    protected function setUp()
    {
        $this->firstName = "testFirstName";
        $this->lastName = "testLastName";
        $this->trustableEmail = "test@cs2i-lorient.fr";
        $this->untrustableEmail = "test@test.test";
        $this->badEmail = "testBadEmail";
        $this->plainPassword = "testPassword";
    }

    public function testInscription()
    {
        $client = static::createClient();
        $crawler = $client->request(
            'POST',
            '/addUser',
            array('firstname', $this->firstName),
            array('lastname', $this->lastName),
            array('email', $this->badEmail),
            array('plainPassword',$this->plainPassword)
        );
    }
}