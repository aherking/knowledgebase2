<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/entry")
 */
class EntryController extends AbstractController
{
    /**
     * @Route("/", name="entry_index", methods={"GET"})
     */
    public function index() :Response
    {
        $entries = $this->getDoctrine()
            ->getRepository(Entry::class)
            ->findAll();
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAll();
        return $this->render('entry/index.html.twig', [
            'entries' => $entries,
            'tags' => $tags
        ]);
    }
    /**
     * @Route("/new", name="entry_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entries = new Entry();
        $form = $this->createForm(EntryType::class, $entries);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $entries->setCreated($date);
            $entries->setChanged($date);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entries);
            $entityManager->flush();
            return $this->redirectToRoute('entry_index');
        }
        return $this->render('entry/new.html.twig', [
            'entry' => $entries,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry): Response
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="entry_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entry $entries): Response
    {
        $form = $this->createForm(EntryType::class, $entries);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $entries->setChanged($date);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('entry_index', [
                'id' => $entries->getId(),
            ]);
        }
        return $this->render('entry/edit.html.twig', [
            'entry' => $entries,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="entry_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entry $entries): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entries->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entries);
            $entityManager->flush();
        }
        return $this->redirectToRoute('entry_index');
    }
}
