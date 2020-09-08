<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Password encoder.
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('disabledUser');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'disabledUser'
        ));
        $user->setActive(false);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $manager->persist($user);

        for ($i = 0; $i < 50; ++$i) {
            $user = new User();

            $user->setUsername($this->faker->unique()->name);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin'
            ));
            $user->setActive($this->faker->boolean());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
