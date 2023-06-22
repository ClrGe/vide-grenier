<?php

use App\Utility\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    /**
     * Test generating a hash using a specific string and salt.
     * It verifies that the generated hash matches the expected hash.
     */
    public function testGenerate()
    {
        $string = 'password';
        $salt = 'somesalt';
        $expectedHash = hash("sha256", $string . $salt);

        $generatedHash = Hash::generate($string, $salt);

        $this->assertEquals($expectedHash, $generatedHash);
    }

    /**
     * Test generating a salt with a specific length.
     * It verifies that the generated salt has the expected length.
     */
    public function testGenerateSaltLength()
    {
        $length = 10;

        $generatedSalt = Hash::generateSalt($length);

        $this->assertEquals($length, strlen($generatedSalt));
    }

    /**
     * Test generating a unique hash that is not empty.
     * It verifies that the generated unique hash is not empty.
     */
    public function testGenerateUniqueNotEmpty()
    {
        $generatedUnique = Hash::generateUnique();

        $this->assertNotEmpty($generatedUnique);
    }

    /**
     * Test generating unique hashes that are different from each other.
     * It verifies that the generated unique hashes are not the same.
     */
    public function testGenerateUniqueUnique()
    {
        $generatedUnique1 = Hash::generateUnique();
        $generatedUnique2 = Hash::generateUnique();

        $this->assertNotEquals($generatedUnique1, $generatedUnique2);
    }
}
