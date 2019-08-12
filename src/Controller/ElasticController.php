<?php

namespace App\Controller;

use App\Entity\Entry;
use App\SearchRepository\EntryRepository;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Twig\Node\Expression\Binary\AbstractBinary;

class ElasticController extends AbstractController
{
    /**
     * @Route("/elastic/search", name="elastic_search", methods={"POST", "GET"})
     *
     * @param RepositoryManagerInterface $manager
     * @param Request $request
     *
     * @return
     */
    public function search (RepositoryManagerInterface $manager, Request $request)
    {
        $query = $request->query->all();
        $search = isset($query['q']) && !empty($query['q']) ? $query['q'] : null;

        /** @var EntryRepository $repository */
        $repository = $manager->getRepository(Entry::class);


        $entries = $repository->search($search);


            return $this->render('entry/index.html.twig', [
                'entries' => $entries
            ]);


    }
}