<?php
use App\DCC\External\ExternalSpecFile;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExternalSpecFileTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;
    private $factory;
    private $file;
    private $spec;
    private $actual;
    private $expected;

    public function setUp() {
        parent::setUp();
        $this->factory = factory(App\CustomerSpecRevision::class);
        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);
        $this->spec = factory(App\CustomerSpec::class)->create();

        $this->actual = new Request($this->factory->make([
            "document" => $this->file,
            "revision" => "**"
        ])->toArray());

        $this->spec->customerSpecRevision()->create($this->actual->all());
        $this->expected = ["document" => self::document($this->spec)];
    }

    /** @test */
    public function it_can_add_spec_revision_to_database() {
        (new ExternalSpecFile($this->spec))->persist($this->actual);
        $this->seeInDatabase("customer_spec_revisions", $this->expected);
    }

    /** @test */
    public function it_can_update_spec_revision_to_database() {
        (new ExternalSpecFile($this->spec))->update($this->actual);
        $this->seeInDatabase("customer_spec_revisions", $this->expected);
    }

    private static function document($spec) {
        $year = Carbon::now()->year;
        $name = Str::upper($spec->spec_no);
        return "{$year}/{$spec->spec_no}/{$name}_--.pdf";
    }
}
