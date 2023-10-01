<?php

namespace App\DataFixtures;

use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setId(Id::next());
        $user->setUsername('dqwdq@ewfew.few');
        $user->setEmail('dqwdq@ewfew.few');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                'dqwdq@ewfew.few'
            )
        );

        $manager->persist($user);
        $manager->flush();
    }
}
