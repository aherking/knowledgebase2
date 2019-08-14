<?php
namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_index")
     */
    public function index()
    {
        return $this->render('/profile/index.html.twig');
    }
}