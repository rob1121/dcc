<?php

use App\DCC\Company\UpdateCompanySpecs\UpdateSpecCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UpdateSpecCategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $class;
    private $request;
    private $spec;

    public function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CompanySpec::class)->create();
        $this->spec->companySpecCategory()
            ->save(factory(App\CompanySpecCategory::class)->make());

        $this->request = new Request(factory(App\CompanySpecCategory::class)->make([
            "company_spec_id" => $this->spec->id
        ])->toArray());
        $this->class = new UpdateSpecCategory;
    }

    /** @test */
    public function it_should_update_company_spec_category()
    {
        $this->class->setRequest($this->request);
        $this->class->setSpec($this->spec);
        $this->class->update();

        $this->seeInDatabase("company_spec_categories", $this->request->all());
    }
}
