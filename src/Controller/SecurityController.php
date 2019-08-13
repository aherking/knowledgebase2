<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Json;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $response = new JsonResponse([ 'success' => 'true']);
            return $response;
        }
        else
        {
            return $this->redirect("/");
        }
    }
    /**
     * @Route("/profile/changepassword", name="change_password")
     */
    public function changePassword (Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {

        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $plainPassword = $request->request->get('password');
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);
            $entityManager->flush($user);
        }

        $response = new JsonResponse([ 'success' => 'true']);
        return $response;
    }

}
