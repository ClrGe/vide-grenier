<?php

use PHPUnit\Framework\TestCase;
use App\Models\Articles;

class ArticlesTest extends TestCase
{

    /**
     * Test the count and type of the retrieved articles.
     * It verifies that the retrieved articles are of type array and there is more than one article available.
     */
    public function testGetAllCount()
    {
        $articles = Articles::getAll('');

        $this->assertIsArray($articles);
        $this->assertGreaterThan(1, count($articles));
    }

    /**
     * Test that the retrieved articles contain all the necessary fields and they are not null.
     * It verifies that each field of the first retrieved article is not null.
     */
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

    /**
     * Test the count and type of the retrieved article.
     * It verifies that the retrieved article is an array and contains exactly one item.
     */
    public function testGetOneCount()
    {
        $id = 1;
        $article = Articles::getOne($id);

        $this->assertIsArray($article);
        $this->assertEquals(1, count($article));
    }

    /**
     * Test that the retrieved article contains all the necessary fields and they are not null.
     * It verifies that each field of the retrieved article is not null.
     */
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

    /**
     * Test the count of articles retrieved for a specific user.
     * It verifies that there is at least one article available for the user.
     */
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

    /**
     * Test that articles retrieved by user have the correct user ID.
     * It verifies that each article in the result array has the expected user ID.
     */
    public function testGetByUserHasCorrectUserId()
    {
        $userId = 1;
        $articles = Articles::getByUser($userId);

        for ($i = 0; $i <= count($articles) - 1; $i++) {
            $this->assertEquals($userId, $articles[$i]['user_id']);
        }
    }

    /**
     * Test the count of suggested articles for a user.
     * It verifies that there is at least one suggested article available.
     */
    public function testGetSuggestCount()
    {
        $userId = 1;
        $articles = Articles::getSuggest();

        $this->assertGreaterThan(0, count($articles));
    }

    /**
     * Test saving an article.
     * It verifies that the article is saved correctly with the provided data,
     * and that the saved article matches the expected values.
     */
    public function testGetSuggestPublishedDateNotNull()
    {
        $userId = 1;
        $articles = Articles::getSuggest();

        for ($i = 0; $i <= count($articles) - 1; $i++) {
            $this->assertNotNull($userId, $articles[$i]['published_date']);
        }
    }

    /**
     * Test saving an article.
     * It verifies that the article is saved correctly with the provided data.
     */
    public function testSave()
    {
        $data = [
            'name' => 'ArticleTest Nom',
            'description' => 'ArticleTest Description',
            'user_id' => 1,
        ];

        $published_date =  new DateTime();
        $published_date = $published_date->format('Y-m-d');

        $articleId = Articles::save($data);

        $this->assertIsInt((int)$articleId);

        $article = Articles::getOne($articleId)['0'];
        $this->assertEquals($data['name'], $article['name']);
        $this->assertEquals($data['description'], $article['description']);
        $this->assertEquals($data['user_id'], $article['user_id']);
        $this->assertEquals($published_date, $article['published_date']);
    }

    /**
     * Test attaching a picture to an article.
     * It verifies that the picture field is updated after attaching a picture.
     */
    public function testAttachPicture()
    {
        $articleId = 1;

        $date =  new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $picturename = 'picture' . $date;

        $articleBefore = Articles::getOne($articleId)['0'];
        Articles::attachPicture($articleId, $picturename);
        $articleAfter = Articles::getOne($articleId)['0'];

        $this->assertNotEquals($articleBefore['picture'], $articleAfter['picture']);
    }
}
