<?php

use App\DCC\Company\UpdateCompanySpecs\UpdateCompanySpecs;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UpdateCompanySpecsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $class;
    private $request;
    private $spec;

    public function setUp()
    {
        parent::setUp();
        $this->class = new UpdateCompanySpecs;
        $this->request = new Request(factory(App\CompanySpec::class)->make()->toArray());
        $this->spec = factory(App\CompanySpec::class)->create();
    }
    
    /** @test */
    public function it_should_update_company_spec_database()
    {
        $this->class->setRequest($this->request);
        $this->class->setSpec($this->spec);
        $this->class->update();
        $this->seeInDatabase("company_specs", $this->request->all());
    }
}
