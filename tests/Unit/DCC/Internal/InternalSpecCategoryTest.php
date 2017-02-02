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
        $category = $this->factory->create()->toArray();

        $this->actual = new Request(array_merge($category,['category' => $category['category_no']]));
        $this->expected = ["category_no" => $this->actual->category_no];

        (new InternalSpecCategory($this->actual, $this->spec))->persist();

        $this->seeInDatabase("company_spec_categories", $this->expected);
    }

    /** @test */
    public function it_can_add_create_instance_if_not_exist()
    {
        $this->actual = new Request(array_merge($this->factory->make()->toArray(),['category' => 'add_category']));
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

    private function createDummyCategoryInstanceForUpdateTest()
    {
        $this->spec->companySpecCategory()->create(
            $this->modelInstance()
        );

        $this->setExpected( ["category_no" => "update spec"] );

        $request = new Request($this->factory->make( $this->expected )->toArray());

        $this->actual = new Request(
            CompanySpecCategory::instance( $request )
        );
    }

    public function setExpected(array $expected)
    {
        $this->expected = $expected;
    }

    private function modelInstance()
    {
        return  CompanySpecCategory::instance(
            new Request($this->factory->make()->toArray())
        );
    }
}
