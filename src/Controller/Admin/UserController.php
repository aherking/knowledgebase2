<?php
namespace App\Controller\Admin;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('/admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function new(Request $request, UserRepository $userRepository)
    {
        $users = $userRepository->findAll();


        return $this->render('/admin/user/new.html.twig', [
            'users' => $users
        ]);
    }

}