<?php
namespace App\DataFixtures;
use App\Entity\Entry;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }


    public function loadData(ObjectManager $manager)
    {

        $this->createMany(User::class,10, function (User $user, $count) {
            $user->setUsername($this->faker->userName);
            $user->setPassword($this->faker->password);

        } );

        $manager->flush();
    }

}