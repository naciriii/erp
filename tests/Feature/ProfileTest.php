<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ProfileTest extends TestCase
{
	use RefreshDatabase;
   
   
    public function testGetProfile()
    {
    	$this->log('TEST GET PROFILE:');
    	$user = User::firstOrCreate(['name' => 'testUser',
    		'email' => 'testEmail@testemail.tetsemail',
    		'password' => bcrypt('123456')]);
    	$this->actingAs($user)
    			->get(route('Profile.get'))
    			->assertStatus(200)
    			->assertViewIs('profile.index');
    }
    public function testPostProfile()
    {
    	$this->noCsrf();
    	$this->log('TEST POST PROFILE:');
    	$user = User::firstOrCreate(['name' => 'testUser',
    		'email' => 'testEmail@testemail.tetsemail',
    		'password' => bcrypt('123456')]);

    	$user_updated = ['name' => 'testUser1',
    		'email' => 'testEmail@testemail.tetsemail'];
    	$this->log('successful response');
    	$this->actingAs($user)
    			->post(route('Profile.post'),$user_updated)
    			->assertSessionHas('response');

    	$this->log('user has been updated');
    	$this->assertDatabaseMissing('users', ['id' => $user->id,'name' =>'testUser']);
    	$this->assertDatabaseHas('users',['id' => $user->id, 'name' => 'testUser1']);		


    }
}
