<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Modus;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entry;

class ModusController extends AbstractController
{
    /**
     * @Route("/modus", name="modus_index", methods={"GET"})
     */

    public function index()
    {
          return true;
    }
}