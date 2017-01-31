<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/01/2017
 * Time: 10:51
 */

namespace Test\AppBundle\Entity;
use PHPUnit_Framework_TestCase;
use AppBundle\Entity\User;


class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var string $firstName
     */
    protected $firstName;

    /**
     * @var string $firstName
     */
    protected $lastName;

    /**
     * @var string $firstName
     */
    protected $trustableEmail;

    /**
     * @var string $untrustableEmail
     */
    protected $untrustableEmail;

    /**
     * @var string $badEmail
     */
    protected $badEmail;

    /**
     * @var string $plainPassword
     */
    protected $plainPassword;

    /**
     * Fonction d'initialisation des test unitaires avec des données
     */
    public function setUp()
    {
        $this->firstName = "testFirstName";
        $this->lastName = "testLastName";
        $this->trustableEmail = "test@cs2i-lorient.fr";
        $this->untrustableEmail = "test@test.test";
        $this->badEmail = "notAnEmail";
        $this->plainPassword = "testPassword";
        $this->user = new User();
    }

    public function testNotAnEmail() {
        $this->assertFalse(
            $this->user->setEmail(
                $this->badEmail
            )
        );
    }

    public function testTrustableEmail() {
        $this->assertTrue(
            $this->user->setEmail(
                $this->trustableEmail
            )
        );
    }

    public function testUntrustableEmail() {
        $this->assertTrue(
            $this->user->setEmail(
                $this->trustableEmail
            )
        );
    }
}