<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanySpecCategoryModelTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function it_present_category_name()
    {
        $category = factory(App\CompanySpecCategory::class)->create([
            "category_no" => "tfp", "category_name" => "test name"
        ]);
        $this->assertEquals("TFP - Test Name", $category->category_title);
    }
}
