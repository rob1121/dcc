<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerSpecModelTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, DatabaseTransactions;
    
    private $spec;

    public function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CustomerSpec::class)->create([
            "spec_no" => "nyeknyek", "name" => "test spec"
        ]);
        
        $this->createCustomerSpecRevision();
    }
    
    /** @test */
    public function it_present_model_spec_name()
    {
        $spec_name = "NYEKNYEK - TEST SPEC";
        $this->assertEquals($spec_name, $this->spec->spec_name);
    }

    /** @test */
    public function it_present_latest_revision()
    {
        $this->assertEquals("*A", $this->spec->latest_revision);
    }
    
    /** @test */
    public function it_present_latest_date()
    {
        $this->assertEquals("2016-01-02", $this->spec->latest_revision_date);
    }

    /** @test */
    public function it_present_external_show_link()
    {
        $route_show = route("external.show", ["external" => $this->spec->id]);
        $this->assertEquals($route_show, $this->spec->external_show);
    }

    /** @test */
    public function it_present_external_edit_link()
    {
        $route_edit = route("external.edit", ["external" => $this->spec->id]);
        $this->assertEquals($route_edit, $this->spec->external_edit);
    }

    private function createCustomerSpecRevision()
    {

        factory(App\CustomerSpecRevision::class)->create([
            "revision" => "**", "customer_spec_id" => $this->spec->id, "revision_date" => "2016-01-01"
        ]);

        factory(App\CustomerSpecRevision::class)->create([
            "revision" => "*A", "customer_spec_id" => $this->spec->id,"revision_date" => "2016-01-02"
        ]);
    }
}
