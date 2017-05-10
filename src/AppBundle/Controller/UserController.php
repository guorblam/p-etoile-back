<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\UserType;
use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends Controller
{
    /**
     * @ApiDoc(
     *    resource=true,
     *    description="Récupère la liste des utilisateurs de l'application",
     *    output= { "class"=User::class, "groups"={"user"}}
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findAll();
        /* @var $users User[] */

        return $users;
    }

    /**
     * @ApiDoc(
     *    resource=true,
     *    description="Récupère un utilisateur de l'application",
     *    output= { "class"=User::class, "groups"={"user"}}
     * )
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/{user_id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($request->get('user_id'));
        /* @var $user User */

        if (empty($user)) {
            return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @ApiDoc(
     *    resource=true,
     *    description="Crée un utilisateur dans l'application",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "fos_rest_form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/addUser")
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups'=>['Default', 'New']]);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            //vérification du domaine de l'email
            //$testDomaine=$this->isDomainOk($this->getDomainFromEmail($user->getEmail()));
            //test de la promotion
            $testPromotion = $this->isPromotionOk($user->getPromotion());
            if($testPromotion===true){
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($user);
                $em->flush();
                return $user;
            }else{
                $this->invalidCredentials();
            }



        } else {
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *    resource=true,
     *    description="Mise à jour totale d'un utilisateur",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Mise à jour avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "fos_rest_form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }

    /**
     * @ApiDoc(
     *    resource=true,
     *    description="Mise à jour partielle d'un utilisateur",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Mise à jour avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "fos_rest_form_errors"=true, "name" = ""}
     *    }
     * )
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    private function isPromotionOk($promotion){
        $year = date('Y');
        if($year-2005<$promotion){
            return false;
        }else{
            return true;
        }
    }

    private function isDomainOk($domaine){
        $domain = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Domaine')
            ->findOneByDomaine($domaine);
        if(!empty($domain)){
            if($domain->getTrusted()===true){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function getDomainFromEmail($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}