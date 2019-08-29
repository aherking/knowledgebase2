<?php
namespace App\Controller;
use App\Entity\Tag;
use App\Entity\Entry;
use App\Entity\Modus;
use App\Entity\User;
use App\Form\EntryFormType;
use App\Repository\EntryRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Service\EntryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EntryController
 * @package App\Controller
 */
/**
 * @Route("/entry")
 */
class EntryController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var EntryService
     */
    protected $entryService;

    /**
     * EntryController constructor.
     * @param EntityManagerInterface $em
     * @param EntryService $entryService
     */
    public function __construct(EntityManagerInterface $em, EntryService $entryService)
    {
        $this->em = $em;
        $this->entryService = $entryService;
    }

    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="entry_index")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="entry_index_paginated")
     *
     * NOTE: For standard formats, Symfony will also automatically choose the best
     * Content-Type header for the response.
     * See https://symfony.com/doc/current/quick_tour/the_controller.html#using-formats
     */
    public function index(Request $request, int $page, EntryRepository $entries, TagRepository $tags, UserRepository $users)
    {
        $tag = null;
        if ($request->query->has('tag')) {
            $tag = $tags->findOneBy(['name' => $request->query->get('tag')]);
        }
        $latestPosts = $entries->findLatest($page, $tag);

        return $this->render('/entry/index.html.twig', [
            'paginator' => $latestPosts,
            'entries' => $entries,
            'tags' => $tags,
            'users' => $users
        ]);
    }

    /**
     * @Route("new", name="entry_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TagRepository $tags)
    {
        $entry = new Entry();
        $entry->setUser($this->getUser());
        $entry->setActive(1);

        $form = $this->createForm(EntryFormType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if(!$form->isValid()) {
                $this->addFlash(
                    'danger',
                    'Formular ungültig'
                );
                return $this->redirectToRoute('entry_new');
            }

            $this->entryService->persist($entry);
            $this->addFlash(
                'success',
                'Artikel wurde erfolgreich gespeichert '
            );
            return $this->redirectToRoute('entry_new');
        }

        return $this->render('entry/new.html.twig',  [
                'tags' => $tags,
            ]
        );
    }

    /**
     * @Route("{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry)
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }
    /**
     * @Route("edit/{id}", name="entry_edit", methods={"GET", "POST"})
     */
    public function edit(Entry $entry, Request $request, TagRepository $tags)
    {
        $form = $this->createForm(EntryFormType::class, $entry);
        $form->handleRequest($request);
        $entry->setUser($this->getUser());
        $entry->setActive(1);

        if ($form->isSubmitted()) {

            if(!$form->isValid()) {
                $this->addFlash(
                    'danger',
                    'Formular ungültig'
                );
                return $this->redirectToRoute('entry_edit', array('id' => $entry->getId()));
            }

            $this->entryService->persist($entry);
            $this->addFlash(
                'success',
                'Artikel wurde erfolgreich gespeichert '
            );
            return $this->redirectToRoute('entry_edit', array('id' => $entry->getId()));
        }

        return $this->render('entry/edit.html.twig', [
            'entry' => $entry,
            'tags' => $tags,
        ]);
    }


}