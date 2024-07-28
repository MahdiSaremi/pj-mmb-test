<?php

namespace Tests\Unit;

use Modules\Account\Models\Account;
use Tests\TestCase;

class LocationDistanceTest extends TestCase
{

    public function test_calculating_distance_from_self()
    {
        $account = new Account([
            'location_latitude' => 25,
            'location_longitude' => 25,
        ]);

        $this->assertSame(0.0, $account->distanceFrom($account));
    }

    public function test_calculating_distance_from_other()
    {
        $miladTower = new Account([
            'location_latitude' => 35.7448,
            'location_longitude' => 51.3755,
        ]);
        $karajNear = new Account([
            'location_latitude' => 35.8352,
            'location_longitude' => 50.9916,
        ]);

        $this->assertSame(36.056, round($miladTower->distanceFrom($karajNear), 3));
    }

}
