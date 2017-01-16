<?php

use App\DCC\ESD\ESDDocuments;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class ESDDocumentTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $spec;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\ESD::class)->create();
    }

    /** @test */
    public function it_can_add_company_spec()
    {
        $expected = ["spec_no" => "number"];

        (new ESDDocuments($this->request))->persist();
        $this->seeInDatabase("esd", $expected);
    }

    /** @test */
    public function it_can_update_company_spec()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];

        (new ESDDocuments($actual, $this->spec))->update();
        $this->seeInDatabase("esd", $expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_can_update_should_throw_exception()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];

        (new ESDDocuments($actual))->update();
        $this->dontSeeInDatabase("esd", $expected);
    }

    private function generateRequestInstance() {
        return new Request([
            "spec_no" => "number",
            "name" => "spec name",
            "revision" => "**",
            "revision_date" => "2016-10-01",
            "document" => new Illuminate\Http\UploadedFile(base_path('tests/Unit/File/test_file.pdf'), 'test_file.pdf', 'application/pdf', 446, null, TRUE),
        ]);
    }

}
