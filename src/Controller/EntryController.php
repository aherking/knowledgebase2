<?php
namespace App\Controller;
use App\Entity\Tag;
use App\Entity\Entry;
use App\Entity\Modus;
use App\Entity\User;
use App\Form\EntryFormType;
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
class EntryController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    protected $entryService;
    public function __construct(EntityManagerInterface $em, EntryService $entryService)
    {
        $this->em = $em;
        $this->entryService = $entryService;
    }

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
     * @Route("entry/new", name="entry_new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();

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
     * @Route("entry/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry)
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }
    /**
     * @Route("entry/edit/{id}", name="entry_edit", methods={"GET", "POST"})
     */
    public function edit(Entry $entry, Request $request)
    {
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();

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