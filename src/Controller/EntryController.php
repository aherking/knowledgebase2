<?php
namespace App\Controller;
use App\Entity\Tag;
use App\Entity\Entry;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class EntryController extends AbstractController
{
    /**
     * @Route("/entry")
     */
    public function index()
    {
        $entries = $this->getDoctrine()
            ->getRepository(Entry::class)
            ->findAll();
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();
        $users = $this->getDoctrine()
            ->getRepository((User::class))
            ->findAll();
        return $this->render('/entry/index.html.twig', [
            'entries' => $entries,
            'tags' => $tags,
            'users' => $users
        ]);
    }
    /**
     * @Route("entry/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry)
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }
    /**
     * @Route("entry/edit/{id}", name="entry_edit", methods={"GET"})
     */
    public function edit(Entry $entry)
    {
        return $this->render('entry/edit.html.twig', [
            'entry' => $entry,
        ]);
    }
}