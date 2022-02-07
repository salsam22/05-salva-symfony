<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Rol;
use App\Entity\Shirt;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $categoriesDefault = ['Black', 'Blue', 'Red', 'Yellow'];
        $categories = [];

        for ($i=0; $i<4; $i++) {
            $category = new Category();
            $category->setName($categoriesDefault[$i]);
            $manager->persist($category);
            $categories[] = $category;
        }
        $manager->flush();

        $rolesDefault = ['ROLE_ADMIN', 'ROLE_CREATOR', 'ROLE_USER'];
        $roles = [];

        for ($i=0; $i<3; $i++) {
            $rol = new Rol();
            $rol->setName($rolesDefault[$i]);
            $manager->persist($rol);
            $roles[] = $rol;
        }
        $manager->flush();

        $users = [];

        $user = new User();
        $user->setName('administrador');
        $user->setEmail('admin@admin.com');
        $user->setUsername('admin');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRol($roles[0]);
        $manager->persist($user);
        $users[] = $user;

        $user = new User();
        $user->setName('creador');
        $user->setEmail('creator@creator.com');
        $user->setUsername('creator');
        $password = $this->hasher->hashPassword($user, 'creator');
        $user->setPassword($password);
        $user->setRol($roles[1]);
        $manager->persist($user);
        $users[] = $user;

        $user = new User();
        $user->setName('usuari');
        $user->setEmail('user@user.com');
        $user->setUsername('user');
        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $user->setRol($roles[2]);
        $manager->persist($user);
        $users[] = $user;

        $manager->flush();

        for ($i=0; $i<18; $i++) {
            $shirt = new Shirt();
            $shirt->setTitle(ucwords($this->faker->words(3, true)));
            $shirt->setDescription($this->faker->text(150));
            $shirt->setUploadDate($this->faker->dateTime);
            $shirt->setImage($this->faker->file('assets', 'public/images', false));
            $shirt->setCategory($categories[\array_rand($categories)]);
            $shirt->setUser($users[\array_rand($users)]);
            $manager->persist($shirt);
        }
        $manager->flush();

    }
}
