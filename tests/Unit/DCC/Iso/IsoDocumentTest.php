<?php

use App\DCC\Iso\IsoDocument;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class IsoDocumentTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $spec;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec = factory(App\Iso::class)->create();
    }

    /** @test */
    public function it_can_add_company_spec()
    {
        $expected = ["spec_no" => "number"];

        (new IsoDocument($this->request))->persist();
        $this->seeInDatabase("isos", $expected);
    }

    /** @test */
    public function it_can_update_company_spec()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];

        (new IsoDocument($actual, $this->spec))->update();
        $this->seeInDatabase("isos", $expected);
    }

    /**
     * @expectedException App\DCC\Exceptions\SpecNotFoundException
     * @test */
    public function it_can_update_should_throw_exception()
    {
        $actual = $this->generateRequestInstance();
        $expected = ["spec_no" => "number"];

        (new IsoDocument($actual))->update();
        $this->dontSeeInDatabase("isos", $expected);
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
