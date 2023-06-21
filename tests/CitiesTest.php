<?php

use App\Models\Cities;
use PHPUnit\Framework\TestCase;

class CitiesTest extends TestCase
{
    public function testSearchUnique()
    {
        $str = 'Rouen';

        $city = Cities::search($str);

        $this->assertIsArray($city);
        $this->assertEquals(1,count($city));
        $this->assertIsInt($city['0']);
    }

    public function testSearchMultiple()
    {
        $str = 'Saint';

        $city = Cities::search($str);

        $this->assertIsArray($city);
        $this->assertGreaterThan(1,count($city));
        $this->assertIsInt($city['0']);
    }
}
