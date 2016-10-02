<?php

use App\CompanySpecCategory;
use App\DCC\Internal\InternalSpecCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class InternalSpecCategoryTest extends TestCase
{
    private $actual;
    private $expected;
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
        $this->actual = new Request($this->factory->make()->toArray());
        $this->expected = ["category_no" => $this->actual->category_no];

        (new InternalSpecCategory($this->actual, $this->spec))->persist();

        $this->seeInDatabase("company_spec_categories", $this->expected);
    }

    /** @test */
    public function it_can_update_instance_of_spec_category()
    {
        $this->createDummyCategoryInstanceForUpdateTest();
        (new InternalSpecCategory($this->actual, $this->spec))->update();

        $this->seeInDatabase("company_spec_categories", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_can_throw_exception_on_update_instance_of_spec_category()
    {
        $this->createDummyCategoryInstanceForUpdateTest();
        (new InternalSpecCategory($this->actual))->update();

        $this->dontSeeInDatabase("company_spec_categories", $this->expected);
    }

    private function modelInstance($request)
    {
        $companySpecCategory = new CompanySpecCategory($request->toArray());
        return $companySpecCategory->toArray();
    }

    private function createDummyCategoryInstanceForUpdateTest()
    {
        $model_instance = CompanySpecCategory::instance(
            new Request($this->factory->make()->toArray())
        )->toArray();

        $this->spec->companySpecCategory()->create($model_instance);
        $this->expected = ["category_no" => "update spec"];

        $this->actual = new Request(
            CompanySpecCategory::instance(new Request($this->factory->make(["category_no" => "update spec"])->toArray()))->toArray()
        );
    }
}
