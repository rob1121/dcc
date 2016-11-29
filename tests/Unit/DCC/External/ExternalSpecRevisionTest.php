<?php
use App\DCC\External\ExternalSpecRevision;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class ExternalSpecRevisionTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $spec;
    private $rev_instance;
    private $actual;
    private $expected;

    protected function setUp() {
        parent::setUp();
        $this->spec = factory(App\CustomerSpec::class)->create();
        $this->rev_instance = $this->generateRequestInstance()->toArray();
    }

    /** @test */
    public function it_should_add_data_to_customer_spec_revision() {
        $this->actual = new Request(factory(App\CustomerSpecRevision::class)->make($this->rev_instance)->toArray());

        $this->expected = (new App\CustomerSpecRevision($this->actual->all()))->toArray();

        array_pull($this->expected, "document");
        (new ExternalSpecRevision($this->actual, $this->spec))->persist();

        $this->seeInDatabase("customer_spec_revisions", $this->expected);
    }

    /** @test */
    public function it_should_update_data_from_customer_spec_revision() {
        $this->requestInstanceForUpdate();

        (new ExternalSpecRevision($this->actual, $this->spec))->update();
        $this->seeInDatabase("customer_spec_revisions", $this->expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_should_throw_exception_on_update_data_from_customer_spec_revision() {
        $this->requestInstanceForUpdate();

        (new ExternalSpecRevision($this->actual))->update();
        $this->dontSeeInDatabase("customer_spec_revisions", $this->expected);
    }

    private function persistDummyDatabaseDataForRevision()
    {
        $this->spec->customerSpecRevision()->create($this->actual->all());
    }

    protected function generateRequestInstance() {

        return new Request([
            "spec_no" => "number",
            "name" => "spec name",
            "revision" => "**",
            "reviewer" => "QC",
            "revision_date" => "2016-01-01",
            "customer_name" => "customer",
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

    protected function requestInstanceForUpdate()
    {
        $this->actual = new Request(factory(App\CustomerSpecRevision::class)->make($this->rev_instance)->toArray());
        $this->persistDummyDatabaseDataForRevision();
        $this->actual["revision"] = "aa";
        $this->expected = [
            "revision" => "aa",
        ];
    }

}
