<?php
use App\DCC\External\ExternalSpecCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExternalSpecCategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $spec;

    protected function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CustomerSpec::class)->create();
    }

    /** @test */
    public function it_should_add_data_to_customer_spec() {
        $actual = new Request(factory(App\CustomerSpecCategory::class)->make()->toArray());
        $expected = (new \App\CustomerSpecCategory($actual->all()))->toArray();

        (new ExternalSpecCategory($this->spec))->persist($actual);

        $this->seeInDatabase("customer_spec_categories", $expected);
    }

    /** @test */
    public function it_should_update_to_customer_spec_category() {
        $actual = new Request(factory(App\CustomerSpecCategory::class)->make()->toArray());
        $this->spec->customerSpecCategory()->create($actual->all());

        $expected = (new \App\CustomerSpecCategory($actual->all()))->toArray();

        (new ExternalSpecCategory($this->spec))->update($actual);

        $this->seeInDatabase("customer_spec_categories", $expected);
    }

}
