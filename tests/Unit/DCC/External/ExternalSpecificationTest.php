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
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\CustomerSpec::class)->create();
    }

    /** @test */
    public function it_can_add_customer_spec()
    {
        $expected = ["spec_no" => "number"];

        (new ExternalSpecification)->persist($this->request);
        $this->seeInDatabase("customer_specs", $expected);
    }

    /** @test */
    public function it_can_update_customer_spec()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];
        $this->spec->customerSpecRevision()->create(factory(App\CustomerSpecRevision::class)->make()->toArray());
        (new ExternalSpecification($this->spec))->update($actual);
        $this->seeInDatabase("customer_specs", $expected);
    }

    protected function generateRequestInstance() {

        return new Request([
            "spec_no" => "number",
            "name" => "spec name",
            "revision" => "**",
            "reviewer" => "QA",
            "revision_date" => "2016-01-01",
            "customer_name" => "customer",
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

}
