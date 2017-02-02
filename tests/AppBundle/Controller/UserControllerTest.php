<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/01/2017
 * Time: 10:48
 */

namespace Test\AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

class UserControllerTest extends \Test\AppBundle\Controller\MasterControllerTests
{
    protected $userEntityManager;

    public function setUp()
    {
        parent::setUp();
        $this->postInformation = array(
            'firstname'     => 'testName',
            'lastname'      => 'testLastName',
            'plainPassword' => 'testPassword',
            'email'         => '',
            'promotion'     => ''
        );
    }

    public function testReponseCodeRegisterWithTrustedDomain()
    {
        $this->initTrustableInformation();
        $this->sendRequest();
        $this->verifySuccessCode();
    }

    public function testResponseContentRegisterWithTrustedDomain() {
        $this->initTrustableInformation();
        $this->sendRequest();
        $this->verifySuccessContent();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testVerifyUserRegisteredWithTrustedDomain()
    {
        $this->initTrustableInformation();
        $this->sendRequest();
        $this->assertEmailNotVerified();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testActivationLinkWithTrustedDomain()
    {
        $this->initTrustableInformation();
        $this->sendRequest();
        $this->executeActivationLink();
        $this->assertEmailVerified();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testResponseCodeWithExternalDomain()
    {
        $this->initNonTrustedInformation();
        $this->sendRequest();
        $this->verifySuccessCode();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testResponseContentWithExternalDomain()
    {
        $this->initNonTrustedInformation();
        $this->sendRequest();
        $this->verifySuccessContent();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testEmailNotVerifiedWithExternalDomain()
    {
        $this->initNonTrustedInformation();
        $this->sendRequest();
        $this->assertEmailNotVerified();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testActivationLinkWithExternalDomain()
    {
        $this->initNonTrustedInformation();
        $this->sendRequest();
        $this->executeActivationLink();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testResponseSuccessCodeWithTrustedEmail()
    {
        $this->initTrustedInformation();
        $this->sendRequest();
        $this->verifySuccessCode();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testResponseContentCodeWithTrustedEmail()
    {
        $this->initTrustedInformation();
        $this->sendRequest();
        $this->verifySuccessContent();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testAssertEmailNotVerifiedWithTrustedEmail()
    {
        $this->initTrustedInformation();
        $this->sendRequest();
        $this->assertEmailNotVerified();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testActivationLinkWithTrustedEmail()
    {
        $this->initTrustedInformation();
        $this->sendRequest();
        $this->executeActivationLink();
        $this->assertEmailVerified();
        $this->cleanUp($this->postInformation["email"]);
    }

    public function testResponseFailureCodeWithWrongEmail()
    {
        $this->initNotAnEmail();
        $this->sendRequest();
        $this->registeringFailureCode();
    }

    public function testResponseFailureCodeWithWrongPromotion()
    {
        $this->initWrongPromotionInformation();
        $this->sendRequest();
        $this->registeringFailureCode();
    }

    public function initTrustableInformation() {
        $this->postInformation["email"] = "a.becmeur@cs2i-lorient.fr";
        $this->postInformation["promotion"] = "10";
    }

    public function initNonTrustedInformation() {
        $this->postInformation["email"] = "t.duval@gmail.com";
        $this->postInformation["promotion"] = "5";
    }

    public function initWrongPromotionInformation() {
        $this->postInformation["email"] = "a.becmeur@cs2i-lorient.fr";
        $this->postInformation["promotion"] = "789";
    }

    public function initNotAnEmail() {
        $this->postInformation["email"] = "a.becmeur.fr";
        $this->postInformation["promotion"] = "7";
    }

    public function initTrustedInformation() {
        $email = "preregistered@gmail.com";
        $this->insertEmailIntoDatabase($email);
        $this->postInformation["email"] = $email;
        $this->postInformation["promotion"] = "preselection";
    }

    public function insertEmailIntoDatabase($email) {
        //TODO : Insérer un email dans la base de données
    }

    public function verifySuccessCode()
    {
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function registeringFailureCode()
    {
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    public function executeActivationLink() {
        $user = $this->userEntityManager
            ->findByEmail($this->postInformation["email"]);
        $activationLink = $user->getActivationLink();
        //TODO : Méthode d'exécution du lien
    }

    public function verifySuccessContent()
    {
        $content = json_decode(
            $this->client->getResponse()->getContent()
        );
        $this->assertEquals(
            $this->postInformation["firstname"],
            $content["firstname"]
        );
    }

    public function assertEmailNotVerified() {
        $user = $this->userEntityManager
            ->findByEmail($this->postInformation["email"]);
        $this->assertNotNull($user);
        $this->assertFalse($user->getEmailVerificationStatus());
    }

    public function assertEmailVerified() {
         $user = $this->userEntityManager
            ->findByEmail($this->postInformation["email"]);
        $this->assertNotNull($user);
        $this->assertTrue($user->getRegistrationStatus());
        $this->assertTrue($user->getEmailVerificationStatus());
    }

    public function cleanUp($email) {
        $user = $this->userEntityManager
            ->findByEmail($email);
        $this->userEntityManager->remove($user);
        $this->userEntityManager->flush();
    }
}