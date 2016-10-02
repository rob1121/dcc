<?php
use App\DCC\External\ExternalSpecCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExternalSpecCategoryTest extends TestCase
{
    private $expected;
    private $actual;
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $spec;

    protected function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CustomerSpec::class)->create();
    }

    /** @test */
    public function it_should_add_data_to_customer_spec() {
        $this->actual = new Request(factory(App\CustomerSpecCategory::class)->make()->toArray());
        $this->expected = (new \App\CustomerSpecCategory($this->actual->all()))->toArray();

        (new ExternalSpecCategory($this->actual, $this->spec))->persist();

        $this->seeInDatabase("customer_spec_categories", $this->expected);
    }

    /** @test */
    public function it_should_update_to_customer_spec_category() {
        $this->requestDataForUpdate();

        $this->expected = (new \App\CustomerSpecCategory($this->actual->all()))->toArray();

        (new ExternalSpecCategory($this->actual, $this->spec))->update();

        $this->seeInDatabase("customer_spec_categories", $this->expected);
    }



    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_should_throw_exception_on_update_to_customer_spec_category() {
        $this->requestDataForUpdate();

        (new ExternalSpecCategory($this->actual))->update();

        $this->dontSeeInDatabase("customer_spec_categories", $this->expected);
    }

    protected function requestDataForUpdate()
    {
        $this->actual = new Request(factory(App\CustomerSpecCategory::class)->make()->toArray());
        $this->spec->customerSpecCategory()->create($this->actual->all());

        $this->expected = (new \App\CustomerSpecCategory($this->actual->all()))->toArray();
    }

}
