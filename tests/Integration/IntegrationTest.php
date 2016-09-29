<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IntegrationTest extends TestCase
{
    private $user;
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        $this->user = factory(App\User::class)->create();
    }

    /** @test */
    public function it_redirect_to_internal_spec() {
        $this->visit("/");
        $this->seePageIs("/internal");
        $this->see("Internal Specification");
        $this->seeLink("Internal Specification");
        $this->seeRouteIs("internal.index");
    }

    /** @test */
    public function it_hide_external_spec_link_when_not_log_in() {
        $this->visit("/");
        $this->seePageIs("/internal");
        $this->see("Internal Specification");
        $this->seeRouteIs("internal.index");
        $this->seeLink("Internal Specification");
        $this->dontSeeLink("External Specification");
        $this->dontSeeElement("update");
        $this->dontSeeElement("#update-btn");
        $this->dontSeeElement("#delete-btn");
    }

    /** @test */
    public function it_can_login_dummy_user_and_redirect_to_internal_spec_library() {
        $this->loginUser();
        $this->seeLink("Internal Specification");
        $this->seeLink("External Specification");
    }

    /** @test */
    public function it_should_see_when_admin_user() {
        $this->user = factory(App\User::class)->create(["is_admin" => 1]);

        $this->loginUser();
        $this->visit("/internal");
        $this->seeElement("#update-btn");
        $this->seeElement("#delete-btn");
        $this->visit("/external");
        $this->seeElement("#update-btn");
        $this->seeElement("#delete-btn");
        $this->seeElement("#for-review-btn");
    }
    
    /** @test */
    public function it_can_see_external_specification_link() {
        $this->be($this->user);
        $this->visit('/');
        $this->click('External Specification');
    }

    /** @test */
    public function it_search_and_display_result_on_the_screen() {
        $this->visit('/internal');
        $this->type('specification dummy text for search', 'search-field');
        $this->press("Search");
        $this->see('Search result found for'); //initial string of empty search result
    }

    protected function loginUser()
    {
        $this->visit('/login');
        $this->type($this->user->employee_id, 'employee_id');
        $this->type("secret", 'password');
        $this->press('Login');
        $this->seePageIs('/internal');
        $this->see($this->user->name);
    }
}
