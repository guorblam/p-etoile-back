<?php
namespace AppBundle\Entity;

class Credentials
{
    /**
     * login unique de l'utilisateur
     */
    protected $login;

    /**
     * Password de l'utilisateur
     */
    protected $password;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}