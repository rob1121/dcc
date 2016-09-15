<?php

use App\DCC\Company\AddCompanySpecs\AddCompanySpecs;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class AddCompanySpecsTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    private $request;
    private $addCompanySpecs;
    private $expected;

    protected function setUp()
    {
        parent::setUp();
        $this->addCompanySpecs = new AddCompanySpecs;
        $this->request = new Request([
            "spec_no" => "spec_no",
            "name" => "name",
            "not_included" => "not_included"
        ]);

        $this->expected = [
            "spec_no" => "spec_no",
            "name" => "name"
        ];
    }

    /** @test */
    public function it_make_new_instance_of_company_specs()
    {
        $this->addCompanySpecs->setRequest($this->request);
        $this->addCompanySpecs->setCompanySpecs();
        $actual = $this->addCompanySpecs->getCompanySpecs();

        $this->assertEquals($this->expected, $actual);
    }

    /** @test */
    public function it_can_add_request_instance_into_company_specs_database()
    {
        $this->addCompanySpecs->setRequest($this->request);
        $this->addCompanySpecs->add();

        $this->seeInDatabase("company_specs", $this->expected);
    }
}
