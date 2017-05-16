<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Entity\Domaine;

class DomaineController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/domaines")
     */
    public function getDomainesAction(Request $request){
        $domaines = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Domaine')
            ->findAll();

        return $domaines;
    }
}
