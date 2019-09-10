<?php
namespace App\Controller\Admin;

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
 * @Route("/admin/entry")
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
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="admin_entry_index")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="admin_entry_index_paginated")
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

        return $this->render('/admin/entry/index.html.twig', [
            'paginator' => $latestPosts
        ]);
    }


}


