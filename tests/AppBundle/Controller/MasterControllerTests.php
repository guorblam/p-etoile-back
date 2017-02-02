<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 02/02/2017
 * Time: 19:47
 */

namespace Test\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MasterControllerTests extends WebTestCase
{
    protected $postInformation;
    protected $client;
    protected $method;
    protected $uri;
    protected $server;

    public function setUp() {
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
                $this->postInformation
            ),
            true
        );
    }
}