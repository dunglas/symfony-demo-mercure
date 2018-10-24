<?php

namespace App\Controller;

use Fig\Link\Link;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Discover extends AbstractController
{
    public function __invoke(Request $request)
    {
        $this->addLink($request, new Link('mercure', 'https://demo.mercure.rocks/hub'));

        //$username = $this->getUser()->getUsername();
        $username = 'kevin';
        $token = (new Builder())
            // set other JWT appropriate JWT claims, such as an expiration date
            ->set('mercure', ['subscribe' => $username]) // could also include the security roles
            ->sign(new Sha256(), '!UnsecureChange!') // store the key in a parameter
            ->getToken();

        $response = new JsonResponse(['@id' => '/demo/books/1.jsonld','availability' => 'https://schema.org/InStock']);
        $response->headers->set('set-cookie', sprintf('mercureAuthorization=%s; path=/hub; secure; httponly; SameSite=strict', $token));

        return $response;
    }
}
