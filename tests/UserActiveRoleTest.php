<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class UserActiveRoleTest extends TestCase
{
    public function testShouldNotHaveRole()
    {
        $user = new User();
        $this->assertNotContains(User::ROLE_ACTIVE_USER, $user->getRoles());

        $user->setRoles([User::ROLE_ACTIVE_USER, User::ROLE_USER]);

        $this->assertNotContains(User::ROLE_ACTIVE_USER, $user->getRoles());
    }

    public function testHasRole()
    {
        $user = new User();

        $reflection = new ReflectionClass($user);
        $reflectionProp = $reflection->getProperty('id');
        $reflectionProp->setAccessible(true);
        $reflectionProp->setValue($user, 1);

        $this->assertEquals($user->isActive(), true);
        $this->assertContains(User::ROLE_ACTIVE_USER, $user->getRoles());
    }
}
