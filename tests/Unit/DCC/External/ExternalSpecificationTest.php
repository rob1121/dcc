<?php

use App\CustomerSpec;
use App\DCC\External\ExternalSpecs;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExternalSpecificationTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $spec;
    private $actual;
    private $expected;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\CustomerSpec::class)->create();
    }

    /** @test */
    public function it_can_add_customer_spec()
    {
        $this->expected = ["spec_no" => "number"];

        (new ExternalSpecs($this->request))->persist();
        $this->seeInDatabase("customer_specs", $this->expected);
    }

    /** @test */
    public function it_can_update_customer_spec()
    {
        $this->requestInstanceForUpdate();
        (new ExternalSpecs($this->actual, $this->spec))->update();
        $this->seeInDatabase("customer_specs", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_can_throw_exception_on_update_customer_spec()
    {
        $this->requestInstanceForUpdate();
        (new ExternalSpecs($this->actual))->update();
        $this->dontSeeInDatabase("customer_specs", $this->expected);
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

    protected function requestInstanceForUpdate()
    {
        $this->actual = $this->generateRequestInstance();
        $this->expected = ["spec_no" => "number"];
        $this->spec->customerSpecRevision()->create(factory(App\CustomerSpecRevision::class)->make()->toArray());
    }

}
