<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Utility\Hash;

class UserTest extends TestCase
{
    
    public function testCreateUser()
    {

        $salt = Hash::generateSalt(32);

        $password = Hash::generate('password', $salt);

        $data = [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => $password,
            'salt' => $salt
        ];

        $userId = User::createUser($data);

        $this->assertIsInt((int)$userId);
    }

    public function testGetByLoginIsArray()
    {
        $login = 'testuser@example.com';

        $user = User::getByLogin($login);

        $this->assertIsArray($user);
        $this->assertArrayHasKey('id', $user);
        $this->assertArrayHasKey('username', $user);
        $this->assertArrayHasKey('email', $user);
        $this->assertArrayHasKey('password', $user);
        $this->assertArrayHasKey('salt', $user);
    }

    public function testGetByLoginNotNull()
    {
        $login = 'testuser@example.com';

        $user = User::getByLogin($login);

        $this->assertNotNull($user);
        $this->assertNotNull($user['id']);
        $this->assertNotNull($user['username']);
        $this->assertNotNull($user['email']);
        $this->assertNotNull($user['password']);
        $this->assertNotNull($user['salt']);

    }

    public function testGetByLoginValue()
    {
        $login = 'testuser@example.com';

        $user = User::getByLogin($login);


        $salt = $user['salt'];

        $password = Hash::generate('password', $salt);

        $data = [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => $password,
            'salt' => $salt
        ];

        $this->assertEquals($user['username'], $data['username']);
        $this->assertEquals($user['email'],$data['email']);
        $this->assertEquals($user['password'],$data['password']);
        $this->assertEquals($user['salt'],$data['salt']);
    }
}