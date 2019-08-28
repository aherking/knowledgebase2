<?php
namespace App\Service;

use App\Entity\Entry;
use Doctrine\ORM\EntityManagerInterface;

class EntryService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }


    public function persist(Entry $entry)
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($entry);
        $entityManager->flush();
        $entityManager->refresh($entry);

    }

    public function delete(Entry $entry)
    {
        $entityManager = $this->entityManager;
        $entityManager->remove($entry);
        $entityManager->flush();
    }


}