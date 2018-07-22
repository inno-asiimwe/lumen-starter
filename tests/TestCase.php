<?php

use Illuminate\Support\Facades\Artisan;
use \Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\Console\Application;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseMigrations;
     /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
 
    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function getAuthenticationToken() {
        $this->post('api/v1/auth/login', [
            'email'=>'oduk@andela.com', 'password'=>'password'
        ]);

        return json_decode($this->response->getContent())->token;
    }
}
