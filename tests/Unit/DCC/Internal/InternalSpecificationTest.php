<?php
use App\DCC\External\ExternalSpecification;
use App\DCC\Internal\InternalSpecification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class InternalSpecificationTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $spec;
    private $actual;
    private $expected;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_can_add_company_spec()
    {
        $this->expected = ["spec_no" => "number"];

        (new InternalSpecification($this->request))->persist();
        $this->seeInDatabase("company_specs", $this->expected);
    }

    /** @test */
    public function it_can_update_company_spec()
    {
        $this->requestInstanceForUpdate();
        (new InternalSpecification($this->actual, $this->spec))->update();
        $this->seeInDatabase("company_specs", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_should_throw_exception_on_update_company_spec()
    {
        $this->requestInstanceForUpdate();
        (new InternalSpecification($this->actual))->update();
        $this->dontseeInDatabase("company_specs", $this->expected);
    }

    private function generateRequestInstance() {
        return new Request([
            "spec_no" => "number",
            "name" => "spec name",
            "revision" => "**",
            "revision_summary" => "this is spec",
            "revision_date" => "2016-01-01",
            "category_no" => "company",
            "category_name" => "company",
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

    protected function requestInstanceForUpdate()
    {
        $this->actual = $this->generateRequestInstance();
        $this->expected = ["spec_no" => "number"];
        $this->spec->companySpecRevision()->create(factory(App\CompanySpecRevision::class)->make()->toArray());
    }

}
