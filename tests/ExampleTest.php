<?php

use Laracasts\Integrated\Extensions\Laravel as IntegrationTest;

class ExampleTest extends IntegrationTest
{
    protected $baseUrl = 'http://experience.dev';

    /** @test */
   public function createApplication()
   {

   }

    /** @test */
   public function it_verifies_that_pages_load_properly()
   {
       $this->visit('/');
   }

    /** @test */
    public function it_verifies_the_current_page()
    {
        $this->visit('/some-page')
             ->seePageIs('some-page');
    }

    /** @test */
   public function it_follows_links()
   {
       $this->visit('/page-1')
            ->click('Follow Me')
            ->andSee('You are on Page 2')
            ->onPage('/page-2');
   }

    /** @test */
   public function it_submits_forms()
   {
       $this->visit('page-with-form')
            ->submitForm('Submit', ['title' => 'Foo Title'])
            ->andSee('You entered Foo Title')
            ->onPage('/page-with-form-results');

        // Another way to write it.
        $this->visit('page-with-form')
             ->type('Foo Title', '#title')
             ->press('Submit')
             ->see('You Entered Foo Title');
   }

    /** @test */
   public function it_verifies_information_in_the_database()
   {
       $this->visit('database-test')
            ->type('Testing', 'name')
            ->press('Save to Database')
            ->verifyInDatabase('things', ['name' => 'Testing']);
   }
}