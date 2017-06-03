<?php
namespace AppBundle\Security;

use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Http\HttpUtils;

class AuthTokenAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
    * Durée de validité du token en secondes, 12 heures
    */
    const TOKEN_VALIDITY_DURATION = 12 * 3600;

    protected $httpUtils;

    public function __construct(HttpUtils $httpUtils)
    {
        $this->httpUtils = $httpUtils;
    }

    /**
     * @param $request Request
     * @param $http_call string
     * @param $urls array
     * @return bool
     */
    private function checkRequestFor($method, $request, $urls) {
        foreach ($urls as $url) {
            if ($request->getMethod() === $method && $this->httpUtils->checkRequestPath($request, $url)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Fonction de contrôle des tokens.
     * TODO: Améliorer la gestion des tokens dans un fichier de configuration (fichier, yml, ...)
     * TODO: Normaliser la gestion des url ouvertes pour faire références à des noms de route plutôt qu'aux urls
     *
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        $openPostUrls = array(
            '/auth-tokens',
            '/addUser',
            '/addDomaine'
        );

        $openGetUrls = array(
            '/domaines',
            'checkUser'
        );

        if($this->checkRequestFor("POST", $request, $openPostUrls)) {
            return;
        }
        if($this->checkRequestFor("GET", $request, $openGetUrls)) {
            return;
        }

        $authTokenHeader = $request->headers->get('X-Auth-Token');

        if (!$authTokenHeader) {
            throw new BadCredentialsException('X-Auth-Token header is required');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $authTokenHeader,
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof AuthTokenUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of AuthTokenUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $authTokenHeader = $token->getCredentials();
        $authToken = $userProvider->getAuthToken($authTokenHeader);

        if (!$authToken || !$this->isTokenValid($authToken)) {
            throw new BadCredentialsException('Invalid authentication token');
        }

        $user = $authToken->getUser();
        $pre = new PreAuthenticatedToken(
            $user,
            $authTokenHeader,
            $providerKey,
            $user->getRoles()
        );

        // Nos utilisateurs n'ont pas de role particulier, on doit donc forcer l'authentification du token
        $pre->setAuthenticated(true);

        return $pre;
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
    * Vérifie la validité du token
    */
    private function isTokenValid($authToken)
    {
        return (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // Si les données d'identification ne sont pas correctes, une exception est levée
        throw $exception;
    }
}