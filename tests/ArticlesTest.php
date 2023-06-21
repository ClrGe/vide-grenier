<?php

use PHPUnit\Framework\TestCase;
use App\Models\Articles;

class ArticlesTest extends TestCase
{

    public function testGetAll()
    {
        $articles = Articles::getAll('');

        $this->assertIsArray($articles);
    }

    public function testGetOne()
    {
        // Test the getOne() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }

    public function testAddOneView()
    {
        // Test the addOneView() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }

    public function testGetByUser()
    {
        // Test the getByUser() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }

    public function testGetSuggest()
    {
        // Test the getSuggest() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }

    public function testSave()
    {
        // Test the save() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }

    public function testAttachPicture()
    {
        // Test the attachPicture() method of Articles model
        // Create test data, if required
        // Perform the test assertions using assertions methods like $this->assertEquals()
    }
}
