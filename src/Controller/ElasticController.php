<?php

namespace App\Controller;

use App\Entity\Entry;
use App\SearchRepository\EntryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;

class ElasticController extends AbstractController
{
    /**
     * @Route("/elastic/search", name="elastic_search")
     *
     * @param RepositoryManagerInterface $manager
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search (RepositoryManagerInterface $manager, Request $request)
    {
        $query = $request->query->all();
        $search = isset($query['q']) && !empty($query['q']) ? $query['q'] : null;

        /** @var EntryRepository $repository */
        $repository = $manager->getRepository(Entry::class);

        $entries = $repository->search($search);

        /** @var Entry $superhero */
        foreach ($entries as $entry) {
            $data[] = [
                'name' => $entry->getName(),
            ];
        }
        return new JsonResponse($data);
    }
}