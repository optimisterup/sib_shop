<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Delivary;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface, ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('admin')
            ->setUsernameCanonical('admin')
            ->setEmail('email@email.email')
            ->setEmailCanonical('email@email.email')
            ->setEnabled(true)
            ->setPlainPassword('admin')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}