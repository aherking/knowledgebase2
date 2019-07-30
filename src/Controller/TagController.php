<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entry;

/**
 * @Route("/tag")
 */

class TagController extends AbstractController
{
    /**
     * @Route("/", name="tag_index", methods={"GET"})
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
    /**
     * @Route("/{id}", name="tag_show", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
        $entries = $tag->getEntries();
        return $this->render('/tag/index.html.twig', [
            'tag' => $tag,
            'entries' => $entries
        ]);
    }
}