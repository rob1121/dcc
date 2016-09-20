<?php

use App\DCC\Internal\InternalSpecRevision;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class InternalSpecRevisionTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $file;
    private $spec;
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = factory(App\CompanySpecRevision::class);
        $this->spec = factory(App\CompanySpec::class)->create();
    }
    
    /** @test */
    public function it_can_add_new_spec_revision()
    {
        $actual = new Request($this->factory->make()->toArray());
        $expected = $actual->all();
        array_pull($expected,"document");
        array_pull($expected,"company_spec_id");

        (new InternalSpecRevision($this->spec))->persist($actual);
        $this->seeInDatabase("company_spec_revisions", $expected);
    }

    /** @test */
    public function it_should_update_spec_revision()
    {
        $actual = new Request($this->factory->make([ "revision" => "**" ])->toArray());
        $this->persistDummyDatabaseDataForRevision($actual);
        $actual["revision_summary"] = "summary";
        $expect = [
            "revision" => "**",
            "revision_summary" => "summary"
        ];

        (new InternalSpecRevision($this->spec))->update($actual);
        $this->seeInDatabase("company_spec_revisions", $expect);

    }

    private function persistDummyDatabaseDataForRevision($actual)
    {
        $this->spec->companySpecRevision()->create($actual->all());
    }

}
