<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('admin')
            ->setEmail('admin@admin.admin')
            ->setEnabled('1')
            ->setPlainPassword('admin')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}