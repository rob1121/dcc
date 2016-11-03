<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IsoModelTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, DatabaseTransactions;
    private $iso;

    public function setUp()
    {
        parent::SetUp();

        $this->iso = factory(App\Iso::class)->create([
            "spec_no" => "spec", "name" => "iso name"
        ]);
    }

    public function it_present_title()
    {
        $iso = factory(App\Iso::class)->create([
            "spec_no" => "spec", "name" => "iso name"
        ]);
        $this->assertEquals("SPEC - ISO NAME", $iso->title);
    }

    /** @test */
    public function it_present_iso_show()
    {
        $this->assertEquals(route("iso.show", ["iso" => $this->iso->id]), $this->iso->iso_show);
    }

    /** @test */
    public function it_present_iso_edit()
    {
        $this->assertEquals(route("iso.edit", ["iso" => $this->iso->id]), $this->iso->iso_edit);
    }
}
