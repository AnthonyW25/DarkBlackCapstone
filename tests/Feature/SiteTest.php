<?php

namespace Tests\Feature;

use App\Sale;
use App\Site;
use Carbon\Carbon;
use Tests\TestCase;

class SiteTest extends TestCase
{
    /** @test */
    public function provides_sales_at_date()
    {
        $site = new Site();

        $five_days_ago = Carbon::now()->subDay(5)->toDateString();

        $sales = $site->salesOn($five_days_ago);

        $this->assertInstanceOf(Site::class, $site);

        $this->assertEquals($five_days_ago, $sales->date);
    }
}
