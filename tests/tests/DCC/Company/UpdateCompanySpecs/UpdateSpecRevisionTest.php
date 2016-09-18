<?php

use App\DCC\Company\UpdateCompanySpecs\UpdateSpecRevision;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UpdateSpecRevisionTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $class;
    private $request;
    private $spec;

    public function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CompanySpec::class)->create();
        $this->spec->companySpecRevision()
            ->save(factory(App\CompanySpecRevision::class)->make());

        $this->request = new Request(factory(App\CompanySpecRevision::class)->make([
            "company_spec_id" => $this->spec->id,
            "revision" => "demo",
            "document" => "file"
        ])->toArray());
        
        $this->class = new UpdateSpecRevision;
    }

    /** @test */
    public function it_should_update_company_spec_revision()
    {
        $this->class->setRequest($this->request);
        $this->class->setSpec($this->spec);
        $this->class->update();

        $actual =  collect($this->request)->except("document")->toArray();
        $this->seeInDatabase("company_spec_revisions", $actual);
    }
}
