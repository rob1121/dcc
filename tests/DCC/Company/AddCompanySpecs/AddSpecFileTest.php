<?php

use App\DCC\Company\AddCompanySpecs\AddSpecFile;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddSpecFileTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;


    private $fileUploadClass;
    private $file;
    private $request;
    private $company_spec;

    public function setUp()
    {
        parent::setUp();
        $this->fileUploadClass = new AddSpecFile;
        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);
        $this->request = new Request([
            "revision" => "**",
            "revision_summary" => "demo",
            "revision_date" => "2016-09-16",
            "not_included" => "not_included",
            "document" => $this->file
        ]);

        $revisionInstance = (new App\CompanySpecRevision($this->request->all()))->toArray();

        $this->company_spec = factory(App\CompanySpec::class)->create();
        $this->company_spec->companySpecRevision()
            ->save(factory(App\CompanySpecRevision::class)
            ->make($revisionInstance));
    }

    /** @test */
    public function it_add_document_and_update_revision_database()
    {
        $this->fileUploadClass->setSpec($this->company_spec);
        $this->fileUploadClass->setRequest($this->request);
        $this->fileUploadClass->add();

        $year = Carbon::now()->year;
        $spec_name = $this->company_spec->spec_no;
        $spec_name_upper = Str::upper($spec_name);

        $this->seeInDatabase("company_spec_revisions", ["document" => "{$year}/{$spec_name}/{$spec_name_upper}_--.pdf"]);
    }
}
