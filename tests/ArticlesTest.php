<?php

use PHPUnit\Framework\TestCase;
use App\Models\Articles;

class ArticlesTest extends TestCase
{

    public function testGetAllCount()
    {
        $articles = Articles::getAll('');

        $this->assertIsArray($articles);
        $this->assertGreaterThan(1, count($articles));
    }

    public function testGetAllNotNull()
    {
        $articles = Articles::getAll('');

        $this->assertNotNull($articles[0]['name']);
        $this->assertNotNull($articles[0]['description']);
        $this->assertNotNull($articles[0]['published_date']);
        $this->assertNotNull($articles[0]['user_id']);
        $this->assertNotNull($articles[0]['views']);
        $this->assertNotNull($articles[0]['picture']);
    }

    public function testGetOneCount()
    {
        $id = 1;
        $article = Articles::getOne($id);

        $this->assertIsArray($article);
        $this->assertEquals(1, count($article));
    }

    public function testGetOneNotNull()
    {
        $id = 1;
        $article = Articles::getOne($id);

        $this->assertNotNull($article[0]['name']);
        $this->assertNotNull($article[0]['description']);
        $this->assertNotNull($article[0]['published_date']);
        $this->assertNotNull($article[0]['user_id']);
        $this->assertNotNull($article[0]['views']);
        $this->assertNotNull($article[0]['picture']);
    }

    public function testAddOneView()
    {
        $id = 1;
        $articleBefore = Articles::getOne($id)['0'];
        Articles::addOneView($id);
        $articleAfter = Articles::getOne($id)['0'];

        $viewsBefore = (int)$articleBefore['views'];
        $viewsAfter = (int)$articleAfter['views'];

        $this->assertEquals($viewsAfter, $viewsBefore + 1);
    }

    public function testGetByUserCount()
    {
        $userId = 1;
        $articles = Articles::getByUser($userId);

        $this->assertGreaterThan(0, count($articles));
    }

    public function testGetByUserHasCorrectUserId()
    {
        $userId = 1;
        $articles = Articles::getByUser($userId);

        for ($i = 0; $i <= count($articles) - 1; $i++) {
            $this->assertEquals($userId, $articles[$i]['user_id']);
        }
    }

    public function testGetSuggestCount()
    {
        $userId = 1;
        $articles = Articles::getSuggest();

        $this->assertGreaterThan(0, count($articles));
    }


    public function testGetSuggestPublishedDateNotNull()
    {
        $userId = 1;
        $articles = Articles::getSuggest();

        for ($i = 0; $i <= count($articles) - 1; $i++) {
            $this->assertNotNull($userId, $articles[$i]['published_date']);
        }
    }

    // public function testSave()
    // {
    //     // Test the save() method of Articles model
    //     // Create test data, if required
    //     // Perform the test assertions using assertions methods like $this->assertEquals()
    // }

    // public function testAttachPicture()
    // {
    //     // Test the attachPicture() method of Articles model
    //     // Create test data, if required
    //     // Perform the test assertions using assertions methods like $this->assertEquals()
    // }
}
