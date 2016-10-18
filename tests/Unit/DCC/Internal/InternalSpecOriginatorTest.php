<?php

use App\DCC\Internal\InternalSpecOriginator;
use App\Originator;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class InternalSpecOriginatorTest extends TestCase
{
    private $actual;
    private $expected;
    private $spec;
    private $factory;
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        factory(App\User::class, 10)->create();
        $this->factory = factory(App\Originator::class);
        $this->spec = factory(App\CompanySpec::class)->create();
    }

    /** @test */
    public function it_can_add_instance_to_database()
    {
        $this->actual = new Request($this->factory->make()->toArray());
        $this->expected = ["user_id" => $this->actual->user_id];

        (new InternalSpecOriginator($this->actual, $this->spec))->persist();

        $this->seeInDatabase("originators", $this->expected);
    }

    /** @test */
    public function it_can_update_instance_of_spec_originator()
    {
        $this->createDummyOriginatorInstanceForUpdateTest();
        (new InternalSpecOriginator($this->actual, $this->spec))->update();

        $this->seeInDatabase("originators", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_can_throw_exception_on_update_instance_of_spec_originator()
    {
        $this->createDummyOriginatorInstanceForUpdateTest();
        (new InternalSpecOriginator($this->actual))->update();

        $this->dontSeeInDatabase("originators", $this->expected);
    }

    private function modelInstance($request)
    {
        $companySpecCategory = new Originator($request->toArray());
        return $companySpecCategory->toArray();
    }

    private function createDummyOriginatorInstanceForUpdateTest()
    {
        $model_instance = Originator::instance(
            new Request($this->factory->make()->toArray())
        )->toArray();

        $this->spec->originator()->create($model_instance);
        $this->expected = ["user_id" => 11];

        $this->actual = new Request(
            Originator::instance(new Request($this->factory->make(["user_id" => 11])->toArray()))->toArray()
        );
    }
}
