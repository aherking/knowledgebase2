<?php
namespace App\Controller;
use App\Repository\EntryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entry;
use App\Entity\Modus;
/**
 * @Route("/tag")
 */
class TagController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $maincriteria = ['main' => 1];
        $childcriteria = ['main' => 0];
        $entries = $this->getDoctrine()
            ->getRepository(Entry::class)
            ->findAll();
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findBy($childcriteria);
        $maintags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findBy($maincriteria);
        return $this->render('/tag/index.html.twig', [
            'entries' => $entries,
            'tags' => $tags,
            'maintags' => $maintags,
        ]);
    }

    /**
     * @Route("/{id}", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="tag_show")
     * @Route("/{id}/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="tag_show_paginated")
     */
    public function show(Tag $tag, EntryRepository $entries, int $page)
    {
        $latestPosts = $entries->findLatest($page, $tag);
        return $this->render('tag/show.html.twig', [
            'tag' => $tag,
            'paginator' => $latestPosts
        ]);
    }

    /**
     * @Route("/edit/{id}", name="tag_edit", methods={"GET"})
     */
    public function edit(Tag $tag)
    {
        $modes = $this->getDoctrine()
            ->getRepository((Modus::class))
            ->findAll();
        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'modes' => $modes,
        ]);
    }

    /**
     * @Route("/new/{id}", name="tag_new", methods={"GET"})
     */
    public function new()
    {
        $modes = $this->getDoctrine()
            ->getRepository((Modus::class))
            ->findAll();
        return $this->render('tag/new.html.twig', [
            'modes' => $modes
        ]);
    }
}