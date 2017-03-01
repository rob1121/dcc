<?php

use App\DCC\Internal\InternalSpecs;
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
        $this->spec = factory(App\CompanySpec::class)->create();
        factory(App\CompanySpecCategory::class)->create(["company_spec_id" => $this->spec->id]);
        $this->request = $this->generateRequestInstance();
        factory(App\User::class, 10)->create();
        $this->expected = ["name" => "spec name"];
    }

    /** @test */
    public function it_can_add_company_spec()
    {
        (new InternalSpecs($this->request))->persist();
        $this->seeInDatabase("company_specs", $this->expected);
    }

    /** @test */
    public function it_can_update_company_spec()
    {
        $this->requestInstanceForUpdate();
        (new InternalSpecs($this->actual, $this->spec))->update();
        $this->seeInDatabase("company_specs", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_should_throw_exception_on_update_company_spec()
    {
        $this->requestInstanceForUpdate();
        (new InternalSpecs($this->actual))->update();
        $this->dontseeInDatabase("company_specs", $this->expected);
    }

    private function generateRequestInstance() {

        $category = factory(App\CompanySpecCategory::class)->create();

        return new Request([
            "name" => "spec name",
            "revision" => "**",
            "revision_summary" => "this is spec",
            "revision_date" => "2016-01-01",
            "category" => 'add_category',
            "category_no" => $category->category_no,
            "category_name" => $category->category_name,
            "department" => ["QA", "PE"],
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

    protected function requestInstanceForUpdate()
    {
        $this->actual = $this->generateRequestInstance();
        $this->spec->companySpecRevision()->create(factory(App\CompanySpecRevision::class)->make()->toArray());
    }

}
