<?php

use App\CustomerSpec;
use App\DCC\External\ExternalSpecification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExternalSpecificationTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $spec;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->makeRequestInstanceOfCustomerSpec();
        $this->spec = factory(App\CustomerSpec::class)->create();
    }

    /** @test */
    public function it_can_add_customer_spec()
    {
        (new ExternalSpecification)->persist($this->request);
        $this->seeInDatabase("customer_specs", $this->request->all());
    }

    /** @test */
    public function it_can_update_customer_spec()
    {
        $actual = new Request(["spec_no" => "spec_no"]);
        $expected = ["spec_no" => "spec_no"];

        (new ExternalSpecification($this->spec))->update($actual);
        $this->seeInDatabase("customer_specs", $expected);
    }

    protected function makeRequestInstanceOfCustomerSpec()
    {
        $factory = factory(App\CustomerSpec::class)->make()->toArray();
        $customer_spec = (new CustomerSpec($factory))->toArray();
        return new Request($customer_spec);
    }

}
