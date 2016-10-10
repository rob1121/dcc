<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InternalControllerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function it_index()
    {
        $this->visit("/internal");
        $this->assertViewHas(["categories","show"]);
    }

    /** @test */
    public function it_create()
    {
        $user = factory(App\User::class)->create(["user_type" => "ADMIN"]);
        $this->actingAs($user);
        $this->visit("/internal/create");
        $this->assertViewHas(["category_lists"]);
    }

    /** @test */
    public function it_redirect_home_all_guest()
    {
        $this->visit("/internal/create");
        $this->seePageIs("/login");

        $spec = factory(App\CompanySpec::class)->create();
        $this->visit("/internal/{$spec->id}/edit");
        $this->seePageIs("/login");
    }
}
