<?php
namespace App\Controller;
use App\Entity\Entry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
class StartController extends AbstractController
{
    /**
     * @Route("/", name="start")
     */
    public function index()
    {
        $criteria = ['main' => 1];
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findBy($criteria);

        $entries = $this->getDoctrine()
            ->getRepository(Entry::class)
            ->findAll();

        return $this->render('/start/index.html.twig', [
            'entries' => $entries,
            'tags' => $tags
        ]);


    }
}