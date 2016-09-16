<?php

use App\DCC\Company\AddCompanySpecs\AddSpecCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class AddSpecCategoryTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware, DatabaseMigrations;

    private $request;
    private $category;
    private $expected;
    private $company_spec;

    protected function setUp()
    {
        parent::setUp();
        $this->category = new AddSpecCategory;
        $this->request = new Request([
            "category_no" => "category_no",
            "category_name" => "category_name",
            "not_included" => "not_included"
        ]);
        $this->company_spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_make_new_instance_of_company_specs()
    {
        $this->request = collect($this->request);
        $this->request->pull("not_included");
        $this->expected = $this->request->toArray();

        $this->category->setRequest($this->request);
        $this->category->setCompanySpecCategory();

        $this->assertEquals($this->expected, $this->category->getCompanySpecCategory());
    }

    /** @test */
    public function it_can_add_request_instance_into_company_specs_database()
    {
        $this->request = collect($this->request);
        $this->request->pull("not_included");
        $this->expected = $this->request->toArray();

        $this->category->setRequest($this->request);
        $this->category->setSpec($this->company_spec);
        $this->category->add();

        $this->seeInDatabase("company_spec_categories", $this->expected);
    }
}
