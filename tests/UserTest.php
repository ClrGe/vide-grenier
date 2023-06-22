<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Utility\Hash;

class UserTest extends TestCase
{

    /**
     * Test creating a user and storing the data in the database.
     * It verifies that the user ID returned is an integer, indicating a successful user creation.
     */
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

    /**
     * Test retrieving a user by their login (email) and verifying the result is an array.
     * It verifies that the retrieved user is an array and contains the expected keys.
     */
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

    /**
     * Test retrieving a user by their login (email) and verifying that the result is not null.
     * It verifies that the retrieved user and its specific fields are not null.
     */
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

    /**
     * Test retrieving a user by their login (email) and verifying the correctness of the returned values.
     * It verifies that the retrieved user's username, email, password, and salt match the expected values.
     */
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
        $this->assertEquals($user['email'], $data['email']);
        $this->assertEquals($user['password'], $data['password']);
        $this->assertEquals($user['salt'], $data['salt']);
    }
}
