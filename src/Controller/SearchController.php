<?php
namespace App\Controller;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Entry;
class SearchController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }


    /**
     * @Route("/search", name="search_index")
     */
    public function index()
    {
        $criteria = ['main' => 1];
        $tags = $this->getDoctrine()
            ->getRepository((Tag::class))
            ->findBy($criteria);

        return $this->render('/start/index.html.twig', [ 'tags' => $tags
        ]);
    }
    /**
     * @Route("/search/{searchterm}", name="search_search")
     */
    public function search($searchterm)
    {
        $entries = $this->em->createQueryBuilder()
            ->select(array('e','t'))
            ->from('App\Entity\Entry', 'e')
            ->leftJoin('e.tagID', 't')
            ->where('MATCH(e.name, e.solution, e.error, e.workflow) AGAINST (:searchterm boolean) > 0.0 ')
            ->setParameter('searchterm', $searchterm)
            ->getQuery()
            ->getArrayResult();

        return $this->render('entry/index.html.twig', [
            'entries' => $entries
            ]);
    }
}