<?php
namespace App\Controller;
use App\Entity\Entry;
use App\Repository\EntryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
class StartController extends AbstractController
{
    /**
     * @Route("/", name="start")
     */
    public function index(EntryRepository $entries, TagRepository $tags, $main = 1)
    {
        $maintags = $tags->findByMain($main);

        return $this->render('/start/index.html.twig', [
            'entries' => $entries,
            'tags' => $maintags
        ]);


    }
}