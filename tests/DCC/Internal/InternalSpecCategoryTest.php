<?php

use App\CompanySpecCategory;
use App\DCC\Internal\InternalSpecCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class InternalSpecCategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;
    private $spec;
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = factory(App\CompanySpecCategory::class);
        $this->spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_can_add_instance_to_database()
    {
        $actual = new Request($this->factory->make()->toArray());
        $expected = ["category_no" => $actual->category_no];

        (new InternalSpecCategory($this->spec))->persist($actual);

        $this->seeInDatabase("company_spec_categories", $expected);
    }

    /** @test */
    public function it_can_update_instance_of_spec_category()
    {
        $this->createDummyCategoryInstanceForUpdateTest();
        $actual = new Request($this->modelInstance($this->factory->make([ "category_no" => "update spec" ])));
        $expected = ["category_no" => "update spec"];

        (new InternalSpecCategory($this->spec))->update($actual);

        $this->seeInDatabase("company_spec_categories", $expected);
    }

    private function modelInstance($request)
    {
        $companySpecCategory = new CompanySpecCategory($request->toArray());
        return $companySpecCategory->toArray();
    }

    private function createDummyCategoryInstanceForUpdateTest()
    {
        $model_instance = $this->modelInstance($this->factory->make());
        $this->spec->companySpecCategory()->create($model_instance);
    }
}
