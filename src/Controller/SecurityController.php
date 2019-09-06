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
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function changePassword (Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $oldPassword = $request->get('oldPW');
        $newPassword = $request->get('newPW');
        $newPasswordConfirm = $request->get('newPWConfirm');
        $checkPass = $encoder->isPasswordValid($user, $oldPassword);

        if ($checkPass === true) {
        }
        else {
            return new jsonresponse(array('error' => 'The current password is incorrect or you entered the wrong confirm'));
        }
        if ($newPassword === $newPasswordConfirm) {

        } else
        {
            return new jsonresponse(array('error' => 'The Passwords are not equal'));

        }
            $encoded = $encoder->encodePassword($user, $newPasswordConfirm);

            $user->setPassword($encoded);
            $entityManager->flush($user);


        $response = new JsonResponse([ 'success' => 'true']);
        return $response;
    }

}
