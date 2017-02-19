<?php
namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="domaine")
 */
class Domaine
{
    /**
     * Identifiant du domaine
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * nom de domaine
     *
     * @ORM\Column(type="string")
     */
    protected $domaine;

    /**
     * etat du domaine (trusted or not)
     *
     * @ORM\Column(type="boolean")
     */
    protected $trusted;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * @param mixed $domaine
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;
    }

    /**
     * @return mixed
     */
    public function getTrusted()
    {
        return $this->trusted;
    }

    /**
     * @param mixed $trusted
     */
    public function setTrusted($trusted)
    {
        $this->trusted = $trusted;
    }


}