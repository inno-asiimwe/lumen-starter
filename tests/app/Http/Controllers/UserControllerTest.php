<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class UserControllerTest
 *
 * @category Tests
 * @package  Tests\App\HTTP\Controllers
 */
class UserControllerTest extends TestCase
{
    /**
     * Test unable to get users if not logged in
     */
    public function testGetUsersWithoutLoggingIn()
    {
        $response = $this->get('api/v1/users');

        $response->assertResponseStatus(401);
        $response->seeJsonContains(['error' => 'Authentication Token not provided.']);

    }

    /**
     * Test get users
     */
    public function testGetUsers()
    {
        $token = $this->getAuthenticationToken();

        $this->get('api/v1/users', ['HTTP_Authorization' => $token]);

        $this->assertResponseStatus(200);

        $response = json_decode($this->response->getContent());

        $this->assertNotEmpty($response);

        $this->assertAttributeContains("Charles Oduk", "name", $response->data[0]);

        $this->assertAttributeContains("Dominic Bett", "name", $response->data[1]);

        $this->assertAttributeContains("Madge Kinyanjui", "name", $response->data[2]);

        $this->assertCount(3, $response->data);
    }

    /**
     * Test get a user
     */
    public function testGetUser(){

        $token = $this->getAuthenticationToken();

        $this->get('api/v1/users/1', ['HTTP_Authorization' => $token]);

        $this->assertResponseStatus(200);

        $response = $this->response->getContent();

        $this->assertNotEmpty($response);

        $this->assertContains("id", $response);

        $this->assertContains("email", $response);
    }

    /**
     * Test get a user
     */
    // public function testRegisterUser() {

    //     $response = $this->post('api/v1/users/register', [
    //         'name' => 'Human Person',
    //         'email' => 'hp@gmail.com',
    //         'password' => 'password'
    //     ]);

    //     $response->assertResponseStatus(200);
    // }

}
