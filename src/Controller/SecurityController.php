<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login()
    {
        $response = new Response();
        $response->setContent(json_encode([
            'redirect' => 'true',
            'redirect_url' => '/'
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
