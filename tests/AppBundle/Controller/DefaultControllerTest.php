<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
    }

    /**
     * Test des emails. Pour contrôler l'envoi/réception, changer le paramètre swiftmailer -> disable_delivery à false
     */
    public function testEmail()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $mailer = $container->get('swiftmailer.mailer');
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('tdev7635@gmail.com')
            ->setTo('tholeguen@gmail.com')
            ->setBody(
                "Ey"
            );
        $result = $mailer->send($message);
        $this->assertTrue($result === 1);
    }
}
