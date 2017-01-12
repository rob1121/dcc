<?php

use App\DCC\Internal\InternalSpecCC;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class InternalSpecCCTest extends TestCase {
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    private $cc;
    private $request;
    private $spec;

    protected function setUp() {
        parent::setUp();
        $this->request = $this->generateRequestInstance();
        $this->spec    = factory(App\CompanySpec::class)->create();
        $this->cc      = new InternalSpecCC($this->request->cc?:[], $this->spec);
    }

    /** @test */
    public function it_store_collection_of_email_to_database_cc_when_company_spec_is_updated()
    {
        $this->cc->persist();
        $this->shouldBeIncludedIInDatabase();
    }

    /** @test */
    public function it_update_cc_database_when_company_spec_is_updated()
    {
        $this->cc->update();
        $this->shouldBeIncludedIInDatabase();
    }

    private function generateRequestInstance() {
        return new Request([
            "cc" => [
                "test1@example.com",
                "test2@example.com",
            ]
        ]);
    }

    private function shouldBeIncludedIInDatabase() {
        $this->seeInDatabase("ccs", ["email" => $this->request->cc[0], "company_spec_id" => $this->spec->id]);
        $this->seeInDatabase("ccs", ["email" => $this->request->cc[1], "company_spec_id" => $this->spec->id]);
    }
}