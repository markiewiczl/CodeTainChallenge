<?php

namespace App\DataFixtures;

use App\Entity\Announcements;
use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'pass'));
        $admin->setRoles(['ROLE_ADMIN']);

        $user1 = new Users();
        $user1->setEmail('user1@user.com');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'pass'));
        $user1->setRoles([]);

        $user2 = new Users();
        $user2->setEmail('user2@user.com');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'pass'));
        $user2->setRoles([]);

        $user3 = new Users();
        $user3->setEmail('user3@user.com');
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'pass'));
        $user3->setRoles([]);

        $user4 = new Users();
        $user4->setEmail('user4@user.com');
        $user4->setPassword($this->passwordHasher->hashPassword($user4, 'pass'));
        $user4->setRoles([]);

        $category1 = new Categories();
        $category1->setName('Motoryzacja');

        $category2 = new Categories();
        $category2->setName('Elektronika');

        $category3 = new Categories();
        $category3->setName('Dom i Ogród');

        $category4 = new Categories();
        $category4->setName('Sport');

        $announcement1 = new Announcements();
        $announcement1->setUser($user1);
        $announcement1->setCategory($category1);
        $announcement1->setCreatedAt(new \DateTime('2019-11-12'));
        $announcement1->setDescription('Ładny, nie bity');
        $announcement1->setTitle('Opel');
        $announcement1->setPriceNet(3000000);
        $announcement1->setPriceGross($announcement1->getPriceNet()*1.23);

        $announcement2 = new Announcements();
        $announcement2->setUser($user1);
        $announcement2->setCategory($category2);
        $announcement2->setCreatedAt(new \DateTime('2021-09-22'));
        $announcement2->setDescription('Śmiga jak marzenie');
        $announcement2->setTitle('Laptop');
        $announcement2->setPriceNet(300000);
        $announcement2->setPriceGross($announcement2->getPriceNet()*1.23);

        $announcement3 = new Announcements();
        $announcement3->setUser($user2);
        $announcement3->setCategory($category2);
        $announcement3->setCreatedAt(new \DateTime('2020-11-02'));
        $announcement3->setDescription('Dzwoni niesamowicie');
        $announcement3->setTitle('Telefon');
        $announcement3->setPriceNet(200000);
        $announcement3->setPriceGross($announcement3->getPriceNet()*1.23);

        $announcement4 = new Announcements();
        $announcement4->setUser($user2);
        $announcement4->setCategory($category3);
        $announcement4->setCreatedAt(new \DateTime('2021-10-14'));
        $announcement4->setDescription('Idealny do siedzenia');
        $announcement4->setTitle('Fotel');
        $announcement4->setPriceNet(4000);
        $announcement4->setPriceGross($announcement4->getPriceNet()*1.23);

        $announcement5 = new Announcements();
        $announcement5->setUser($user3);
        $announcement5->setCategory($category4);
        $announcement5->setCreatedAt(new \DateTime('2022-07-22'));
        $announcement5->setDescription('Dają trochę potem, ale kopia niesamowicie');
        $announcement5->setTitle('Buty');
        $announcement5->setPriceNet(15000);
        $announcement5->setPriceGross($announcement5->getPriceNet()*1.23);

        $announcement6 = new Announcements();
        $announcement6->setUser($user3);
        $announcement6->setCategory($category4);
        $announcement6->setCreatedAt(new \DateTime('2022-08-11'));
        $announcement6->setDescription('Prawie nie kopana, oryginalna');
        $announcement6->setTitle('Piłka Gucci');
        $announcement6->setPriceNet(30000000);
        $announcement6->setPriceGross($announcement6->getPriceNet()*1.23);

        $announcement7 = new Announcements();
        $announcement7->setUser($user4);
        $announcement7->setCategory($category3);
        $announcement7->setCreatedAt(new \DateTime('2020-01-12'));
        $announcement7->setDescription('Sie można pobujać');
        $announcement7->setTitle('huśtawka');
        $announcement7->setPriceNet(21000);
        $announcement7->setPriceGross($announcement7->getPriceNet()*1.23);

        $announcement8 = new Announcements();
        $announcement8->setUser($user4);
        $announcement8->setCategory($category1);
        $announcement8->setCreatedAt(new \DateTime('2022-03-21'));
        $announcement8->setDescription('Stan igła, starsza pani jeździła tylko do kościoła i z powrotem');
        $announcement8->setTitle('Bentley');
        $announcement8->setPriceNet(120000000);
        $announcement8->setPriceGross($announcement8->getPriceNet()*1.23);
//        $announcement8->setImage();

        $manager->persist($admin);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);

        $manager->persist($announcement1);
        $manager->persist($announcement2);
        $manager->persist($announcement3);
        $manager->persist($announcement4);
        $manager->persist($announcement5);
        $manager->persist($announcement6);
        $manager->persist($announcement7);
        $manager->persist($announcement8);

        $manager->flush();
    }
}
