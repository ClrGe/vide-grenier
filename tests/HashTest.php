<?php

use App\Utility\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    public function testGenerate()
    {
        $string = 'password';
        $salt = 'somesalt';
        $expectedHash = hash("sha256", $string . $salt);

        $generatedHash = Hash::generate($string, $salt);

        $this->assertEquals($expectedHash, $generatedHash);
    }

    public function testGenerateSaltLength()
    {
        $length = 10;

        $generatedSalt = Hash::generateSalt($length);

        $this->assertEquals($length, strlen($generatedSalt));
    }

    public function testGenerateUniqueNotEmpty()
    {
        $generatedUnique = Hash::generateUnique();

        $this->assertNotEmpty($generatedUnique);
    }

    public function testGenerateUniqueUnique()
    {
        $generatedUnique1 = Hash::generateUnique();
        $generatedUnique2 = Hash::generateUnique();
        
        $this->assertNotEquals($generatedUnique1, $generatedUnique2);
    }
}