<?php

use App\DCC\Company\AddCompanySpecs\AddSpecRevision;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class AddSpecRevisionTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware, DatabaseMigrations;

    private $request;
    private $revision;
    private $expected;
    private $company_spec;
    private $file;

    protected function setUp()
    {
        parent::setUp();
        $this->revision = new AddSpecRevision;
        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);
        $this->request = new Request([
            "revision" => "**",
            "revision_summary" => "demo",
            "revision_date" => "2016-09-16",
            "not_included" => "not_included",
            "document" => $this->file
        ]);
        $this->company_spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_make_new_instance_of_company_specs()
    {
        $this->expected = $this->generateCompanySpecInstanceFromRequest();

        $this->revision->setRequest($this->request);
        $this->revision->setCompanySpecRevision();

        $this->assertEquals($this->expected, $this->revision->getCompanySpecRevision());
    }

    /** @test */
    public function it_can_add_request_instance_into_company_specs_database()
    {
        $this->expected = $this->generateCompanySpecInstanceFromRequest();

        $this->revision->setRequest($this->request);
        $this->revision->setSpec($this->company_spec);
        $this->revision->add();

        $this->seeInDatabase("company_spec_revisions", $this->expected);
    }

    public function generateCompanySpecInstanceFromRequest()
    {
        $this->request = collect($this->request);
        $this->request->pull("not_included");
        $this->request->pull("document");
        return $this->request->toArray();
    }
}
