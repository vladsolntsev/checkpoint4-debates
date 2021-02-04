<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setName('Admin');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'password'
        ));
        $admin->setRoles([User::ADMIN]);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('t@t.com');
        $user1->setName('Tic');
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1,
            'password'
        ));
        $user1->setRoles([User::USER]);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('t2@t.com');
        $user2->setName('Toc');
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'password'
        ));
        $user2->setRoles([User::USER]);
        $manager->persist($user1);

        $manager->flush();
    }
}