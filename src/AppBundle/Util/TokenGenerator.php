<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 03/06/2017
 * Time: 17:02
 */

namespace AppBundle\Util;


use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TokenGenerator implements TokenGeneratorInterface
{

    /**
     * Generates a CSRF token.
     *
     * @return string The generated CSRF token
     */
    public function generateToken()
    {
        return \base64_encode(\random_bytes(32));
    }
}