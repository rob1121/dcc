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

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_can_add_company_spec()
    {
        $expected = ["spec_no" => "number"];

        (new InternalSpecification)->persist($this->request);
        $this->seeInDatabase("company_specs", $expected);
    }

    /** @test */
    public function it_can_update_company_spec()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];
        $this->spec->companySpecRevision()->create(factory(App\CompanySpecRevision::class)->make()->toArray());

        (new InternalSpecification($this->spec))->update($actual);
        $this->seeInDatabase("company_specs", $expected);
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
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

}
