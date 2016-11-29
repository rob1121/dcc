<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanySpecModelTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, DatabaseTransactions;

    private $spec;
    private $spec_id;
    private $originator;
    private $revision;
    private $category;

    public function setUp()
    {
        parent::setUp();
        $this->spec = factory(App\CompanySpec::class)->create(["spec_no" => 0, "name" => "spec"]);
        $this->revision = factory(App\CompanySpecRevision::class)->create(["company_spec_id" => $this->spec->id, "revision_date" => \Carbon::now()->subDays(8)]);
        $this->category = factory(App\CompanySpecCategory::class)->create(["company_spec_id" => $this->spec->id, "category_no" => "TFP00"]);
        $this->originator = factory(App\Originator::class, 2)->create(["company_spec_id" => $this->spec->id]);


        $this->spec_id = $this->spec->companySpecCategory->category_no . " - " . sprintf("%03d", $this->spec->spec_no);
    }

    /** @test */
    public function it_return_Expected_key()
    {
        $this->seeJsonStructure(['id', 'spec_id', 'name'],$this->spec);
    }

    /** @test */
    public function it_return_expected_spec_id()
    {
        $this->assertEquals($this->spec_id, "TFP00 - 000");
    }

    /** @test */
    public function it_return_presenter_spec_name()
    {
        $spec_name = $this->spec_id . ' - ' . "Spec";

        $this->assertEquals($this->spec->spec_name, $spec_name);
    }

    /** @test */
    public function it_return_presenter_originator_department()
    {
        $originator_department = App\Originator::get(['department'])->pluck('department')->toArray();
        $this->assertEquals($this->spec->originator_departments, $originator_department);
    }

    /** @test */
    public function it_display_internal_show_route_link()
    {
        $this->assertEquals($this->spec->internal_show, route("internal.show", ["internal" => $this->spec->id]));
    }

    /** @test */
    public function it_display_internal_destroy_route_link()
    {
        $this->assertEquals($this->spec->internal_destroy, route("internal.destroy", ["internal" => $this->spec->id]));
    }

    /** @test */
    public function it_display_internal_edit_route_link()
    {
        $this->assertEquals($this->spec->internal_edit, route("internal.edit", ["internal" => $this->spec->id]));
    }

    /** @test */
    public function it_trim_string_count()
    {
        $this->assertTrue(strlen($this->spec->revision_summary) <= 53);
    }

    /** @test */
    public function it_highlight_class()
    {
        $this->spec->companySpecRevision->revision_date = \Carbon::parse($this->spec->companySpecRevision->revision_date)->addDays(2);
        $class = $this->generateClass();
        $this->assertEquals("new revision", $class);

        $this->spec->companySpecRevision->revision_date = \Carbon::parse($this->spec->companySpecRevision->revision_date)->subDays(10);
        $class = $this->generateClass();
        $this->assertEquals("", $class);
    }

    /**
     * @return string
     */
    protected function generateClass():string
    {
        $class = $this->spec->companySpecRevision->revision_date > \Carbon::now()->subDays(7)
            ? "new revision"
            : "";
        return $class;
    }
}
