<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
class StartController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $criteria = ['main' => 1];
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findBy($criteria);

        return $this->render('/start/index.html.twig', [ 'tags' => $tags
        ]);
    }
}