<?php

use App\Models\Cities;
use PHPUnit\Framework\TestCase;

class CitiesTest extends TestCase
{
    /**
     * Test searching for a unique city.
     * It verifies that the search result for a specific string returns a single city ID.
     */
    public function testSearchUnique()
    {
        $str = 'Rouen';

        $city = Cities::search($str);

        $this->assertIsArray($city);
        $this->assertEquals(1, count($city));
        $this->assertIsInt($city['0']);
    }

    /**
     * Test searching for multiple cities.
     * It verifies that the search result for a specific string returns multiple city IDs.
     */
    public function testSearchMultiple()
    {
        $str = 'Saint';

        $city = Cities::search($str);

        $this->assertIsArray($city);
        $this->assertGreaterThan(1, count($city));
        $this->assertIsInt($city['0']);
    }
}
