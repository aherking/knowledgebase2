<?php
namespace App\DataFixtures;
use App\Entity\Entry;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine;
use Doctrine\Common\Persistence\ObjectManager;

class EntryFixture extends BaseFixture
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }


    public function loadData(ObjectManager $manager)
    {

        $this->createMany(Entry::class,10, function (Entry $entry, $count) {
            $entry->setName($this->faker->sentence(6, true));
            $entry->setWorkflow($this->faker->randomHtml());
            $entry->setSolution($this->faker->randomHtml());
            $entry->setError($this->faker->randomHtml());
            $tag = $this->faker->numberBetween(1,2);
            $tagID = $this->em
                ->getRepository((Tag::class))
                ->findOneBy(array('id' => $tag));
            $entry->addTagID($tagID);
            $user = $this->faker->numberBetween(1,2);
            $userID = $this->em
                ->getRepository(User::class)
                ->findOneBy(array('id' => $user));
            $entry->setUser($userID);
            $entry->setActive(1);
            $entry->setCreated($this->faker->dateTime);
            $entry->setChanged($this->faker->dateTime());
        } );

        $manager->flush();
    }

}