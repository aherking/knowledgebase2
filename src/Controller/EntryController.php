<?php
namespace App\Controller;
use App\Entity\Tag;
use App\Entity\Entry;
use App\Entity\Modus;
use App\Entity\User;
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
     * @Route("entry/new/create", name="entry_new_create", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request, ValidatorInterface $validator)
    {
            $entityManager = $this->getDoctrine()->getManager();
            $created = new \DateTime();
            $entry = new Entry();
            $entry->setActive(1);
            $entry->setName($request->request->get('InputTitel'));
            $entry->setWorkflow($request->request->get('InputWorkflow'));
            $entry->setSolution($request->request->get('InputSolution'));
            $entry->setError($request->request->get('InputError'));
            $entry->setCreated($created);
            $entry->setChanged($created);
            $entry->setUser($this->getUser());
            $tags = $request->request->get('TagSelect');

            $errors = $validator->validate($entry);
            if (count($errors) > 0)
            {
                $errorString = (string) $errors;
                return new Response($errorString);
            }

            foreach($tags as $tag)
            {
                $tagID = $this->getDoctrine()
                ->getRepository((Tag::class))
                ->findOneBy(array('id' => $tag));
                $entry->addTagID($tagID);
            }

            $entityManager->persist($entry);
            $entityManager->flush();

        return new Response('Saved new product with id '.$entry->getName());

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