<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/01/2017
 * Time: 10:48
 */

namespace Test\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

class UserControllerTest extends WebTestCase
{
    protected $registeringInformation;
    protected $client;
    protected $method;
    protected $uri;
    protected $server;
    protected $userEntityManager;

    public function setUp()
    {
        self::bootKernel();
        $this->userEntityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:User');

        $this->client = static::createClient();
        $this->method = 'POST';
        $this->uri = '/addUser';
        $this->server = array(
            'CONTENT_TYPE' => 'application/json'
        );

        $this->registeringInformation = array(
            'firstname'     => 'testName',
            'lastname'      => 'testLastName',
            'plainPassword' => 'testPassword',
            'email'         => '',
            'promotion'     => ''
        );
    }

    public function testRegisterWithTrustedDomain()
    {
        $this->initTrustableInformation();
        $this->sendRequest();
        $this->registeringSuccessCode();
        $this->registeringSuccessContent();
        $this->assertUserRegisteredNotTrusted();
        $this->getActivationLink();
        //TODO : Méthodes d'activation du lien, email vérifié, utilisateur activé
    }

    public function testRegisterWithExternalDomain()
    {
        $this->initNonTrustedInformation();
        $this->sendRequest();
        $this->registeringSuccessCode();
        $this->registeringSuccessContent();
        $this->assertUserRegisteredNotTrusted();
        $this->getActivationLink();
        //TODO : Méthodes d'activation du lien, email vérifié, utilisateur non activé
    }

    public function testRegisterWithWrongEmail()
    {
        $this->initNotAnEmail();
        $this->sendRequest();
        $this->registeringFailureCode();
    }

    public function testRegisterWithWrongPromotion()
    {
        $this->initWrongPromotionInformation();
        $this->sendRequest();
        $this->registeringFailureCode();
    }

    public function initTrustableInformation() {
        $this->registeringInformation["email"] = "a.becmeur@cs2i-lorient.fr";
        $this->registeringInformation["promotion"] = "10";
    }

    public function initNonTrustedInformation() {
        $this->registeringInformation["email"] = "t.duval@gmail.com";
        $this->registeringInformation["promotion"] = "5";
    }

    public function initWrongPromotionInformation() {
        $this->registeringInformation["email"] = "a.becmeur@cs2i-lorient.fr";
        $this->registeringInformation["promotion"] = "789";
    }

    public function initNotAnEmail() {
        $this->registeringInformation["email"] = "a.becmeur.fr";
        $this->registeringInformation["promotion"] = "7";
    }

    public function registeringSuccessCode()
    {
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function registeringFailureCode()
    {
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    public function getActivationLink() {
        $user = $this->userEntityManager
            ->findByEmail($this->registeringInformation["email"]);
        $this->assertNotNull($user->getActivationLink());
    }

    public function registeringSuccessContent()
    {
        $content = json_decode(
            $this->client->getResponse()->getContent()
        );
        $this->assertContains(
            $this->registeringInformation["firstname"],
            $content["firstname"]
        );
    }

    public function assertUserRegisteredNotTrusted() {
        $user = $this->userEntityManager
            ->findByEmail($this->registeringInformation["email"]);
        $this->assertNotNull($user);
        $this->assertFalse($user->getRegistrationStatus);
        $this->assertFalse($user->getEmailVerificationStatus);
    }

    public function sendRequest()
    {
        $this->client->request(
            $this->method,
            $this->uri,
            array(),
            array(),
            $this->server,
            json_encode(
                $this->registeringInformation
            ),
            true
        );
    }
}