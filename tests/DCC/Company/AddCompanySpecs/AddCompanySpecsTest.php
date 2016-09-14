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

    protected function setUp()
    {
        parent::setUp();
        $this->addCompanySpecs = new AddCompanySpecs;
        $this->request = new Request([
            "spec_no" => "spec_no",
            "name" => "name",
            "not_included" => "not_included"
        ]);
    }

    public function testItReturnCompanySpecsInstance()
    {
        $this->addCompanySpecs->setRequest($this->request);
        $this->addCompanySpecs->setCompanySpecs();
        $actual = $this->addCompanySpecs->getCompanySpecs();

        $expected = [
            "spec_no" => "spec_no",
            "name" => "name"
        ];

        $this->assertEquals($expected, $actual);
    }
}
