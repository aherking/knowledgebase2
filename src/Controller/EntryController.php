<?php
namespace App\Controller;
use App\Entity\Tag;
use App\Entity\Entry;
use App\Entity\Modus;
use App\Entity\User;
use App\Form\EntryFormType;
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
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

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
    public function new()
    {
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();


        return $this->render('entry/new.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * @Route("entry/new2", name="entry_new2", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();

        $entry = new Entry();
        $entry->setUser($this->getUser());
        $entry->setCreated(new \DateTime());
        $entry->setActive(1);
        $entry->setChanged(new \DateTime());



        $form = $this->createForm(EntryFormType::class, $entry);
        $form->handleRequest($request);



        if ($form->isSubmitted()) {

            if(!$form->isValid()) {
                return new Response($form->getErrors(true));
            }
            $entry = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entry);
            $entityManager->flush();

            return new Response('Saved new product with id '.$entry->getName());
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
     * @Route("entry/edit/{id}", name="entry_edit", methods={"GET"})
     */
    public function edit(Entry $entry)
    {
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findAll();
        return $this->render('entry/edit.html.twig', [
            'entry' => $entry,
            'tags' => $tags,
        ]);
    }


}