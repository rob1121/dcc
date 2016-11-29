<?php
use App\CompanySpecRevision;
use App\DCC\Internal\InternalSpecFile;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InternalSpecFileTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;
    private $factory;
    private $file;
    private $spec;
    private $actual;
    private $expected;

    public function setUp()
    {
        parent::setUp();
        $this->factory = factory(App\CompanySpecRevision::class);
        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);
        $this->spec = factory(App\CompanySpec::class)->create();
        factory(App\CompanySpecCategory::class)->create(["company_spec_id" => $this->spec->id]);
        $this->actual = new Request($this->factory->make([
            "document" => $this->file,
            "revision" => "**"
        ])->toArray());

        $this->spec->companySpecRevision()->create($this->actual->all());
        $this->expected = ["document" => self::document($this->spec)];
    }

    /** @test */
    public function it_can_add_spec_revision_to_database()
    {
        (new InternalSpecFile($this->actual, $this->spec))->persist();

        $this->assertEquals(CompanySpecRevision::first()->document, $this->expected['document']);
        $this->seeInDatabase("company_spec_revisions", $this->expected);
    }

    /** @test */
    public function it_can_update_spec_revision_to_database()
    {
        (new InternalSpecFile($this->actual, $this->spec))->update();
        $this->assertEquals(CompanySpecRevision::first()->document, $this->expected['document']);
        $this->seeInDatabase("company_spec_revisions", $this->expected);
    }

    private static function document($spec)
    {
        $year = Carbon::now()->year;
        $path = $spec->companySpecCategory->category_no ." ". $spec->spec_no;

        return $year."/".$path."/".$path."_  .pdf";
    }
}
