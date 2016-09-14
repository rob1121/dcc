<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class SearchTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations, WithoutMiddleware;
    private $request;

    public function setUp()
    {
        parent::setUp();
        Artisan::call("migrate");
        $this->request = new Request([
            "spec_no" => "tfp"
        ]);
    }

    public function test_it_get_request_for_search()
    {
        $expected = ["spec_no" => "tfp"];
        $search = new \App\Dcc\API\Search($this->request);

        $this->assertInstanceOf(Request::class, $search->getRequest());
        $this->assertEquals($expected, $search->getRequest()->all());

    }

    public function test_it_factory()
    {
        $spec = factory(App\CompanySpec::class)->create(["spec_no" => "demo_no"]);
        $this->assertEquals("demo_no", $spec->spec_no);
    }
}
