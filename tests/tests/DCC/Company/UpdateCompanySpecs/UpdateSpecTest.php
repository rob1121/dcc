<?php

use App\DCC\Company\UpdateCompanySpecs\UpdateSpec;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UpdateSpecTest extends TestCase
{
    private $file;
    private $spec;
    private $revision;
    private $category;
    private $initData;
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;


    protected function setUp()
    {
        parent::setUp();

        $this->file = new Illuminate\Http\UploadedFile(base_path('tests/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE);

        $this->initData = factory(App\CompanySpec::class)->create();
        $this->initData->companySpecRevision()->save(factory(App\CompanySpecRevision::class)->make(["document" => $this->file]));
        $this->initData->companySpecCategory()->save(factory(App\CompanySpecCategory::class)->make());

        $this->spec = factory(App\CompanySpec::class)->make();
        $this->revision = factory(App\CompanySpecRevision::class)->make(["document" => $this->file]);
        $this->category = factory(App\CompanySpecCategory::class)->make();
    }

    /**
     * @expectedException         Illuminate\Validation\ValidationException
     * @expectedExceptionMessage  The given data failed to pass validation.
     * @test
     **/
    public function it_throws_exceptions_upon_validation_validation()
    {
        $request = new Request($this->spec->toArray());
        (new UpdateSpec($request))->validateSpec();
    }

    /** @test */
    public function it_should_pass_request_validation()
    {
        $spec = $this->companySpecInstance();
        $spec->validateSpec();
    }

    /** @test */
    public function it_should_create_new_specs()
    {
        $spec = $this->companySpecInstance();
        $spec->validateSpec();
        $spec->update();

        $this->revision = collect($this->revision);
        $this->revision->pull("document");
        $this->revision->pull("company_spec_id");

        $this->category = collect($this->category);
        $this->category->pull("company_spec_id");

        $this->seeInDatabase("company_specs", $this->spec->toArray());
        $this->seeInDatabase("company_spec_revisions", $this->revision->toArray());
        $this->seeInDatabase("company_spec_categories", $this->category->toArray());
    }

    private function companySpecInstance()
    {
        $new_spec_instance = collect($this->spec)->merge($this->revision)->merge($this->category)->toArray();

        $request = new Request($new_spec_instance);
        $spec = new UpdateSpec($request);
        $spec->setSpec($this->initData);
        return $spec;
    }

}
