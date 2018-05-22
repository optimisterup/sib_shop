<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Delivary;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArticleData implements FixtureInterface, ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new User();
        $article
            ->setUsername('admin')
            ->setEmail('email@email.email')
            ->setEnabled(true)
            ->setPlainPassword('admin')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $manager->persist($article);

        $delivery= new Delivary();
        $delivery
                ->setStatus('Ready');
        $manager->flush();
    }
}