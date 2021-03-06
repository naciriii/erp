<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;


class AuthTest extends TestCase
{
    use RefreshDatabase;
	
	private $user;
    
	public function setUp()
	{
		 parent::setUp(); 
		$this->user = factory(User::class)->create();
	}
    
    public function testGetLogin()
    {

    	$response = $this->get('/login');
    	$response->assertStatus(200);
    }
    public function testAutorizationDisallowed()
    {
    	$response = $this->get('/');
    	$response->assertRedirect('/login');
    }
    public function testAutorizationAllowed()
    {
    
    	$this->actingAs($this->user)
    			->get('/')
    			->assertStatus(200);
    	
    }
    public function testLogout()
    {

       $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
       $response =  $this->actingAs($this->user)
               ->post('/logout')
               ->assertRedirect('/');
    }

}
