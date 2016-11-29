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
    private $expected;
    private $actual;

    public function setUp()
    {
        parent::setUp();
        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);
        $this->factory = factory(App\CompanySpecRevision::class);
        $this->spec = factory(App\CompanySpec::class)->create();
        factory(App\CompanySpecCategory::class)->create(["company_spec_id" => $this->spec->id]);
    }
    
    /** @test */
    public function it_can_add_new_spec_revision()
    {
        $this->actual = new Request($this->factory->make(["document" => $this->file])->toArray());
        $expected = $this->actual->all();
        array_pull($expected,"document");
        array_pull($expected,"company_spec_id");

        (new InternalSpecRevision($this->actual, $this->spec))->persist();
        $this->seeInDatabase("company_spec_revisions", $expected);
    }

    /** @test */
    public function it_should_update_spec_revision()
    {
        $this->requestInstanceForUpdate();

        (new InternalSpecRevision($this->actual, $this->spec))->update();
        $this->seeInDatabase("company_spec_revisions", $this->expected);

    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_should_throw_exception_on_update_spec_revision()
    {
        $this->requestInstanceForUpdate();

        (new InternalSpecRevision($this->actual))->update();
        $this->dontSeeInDatabase("company_spec_revisions", $this->expected);

    }

    private function persistDummyDatabaseDataForRevision()
    {
        $this->spec->companySpecRevision()->create($this->actual->all());
    }

    protected function requestInstanceForUpdate()
    {
        $this->actual = new Request($this->factory->make(["revision" => "**", "document" => $this->file])->toArray());
        $this->persistDummyDatabaseDataForRevision();
        $this->actual["revision_summary"] = "summary";
        $this->expected = [
            "revision" => "**",
            "revision_summary" => "summary"
        ];
    }

}
