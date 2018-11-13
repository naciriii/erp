<?php

namespace Modules\Authorization\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Role;

class RolesTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
  
    public function testAddRole()
    {
    	$this->log('TEST ADD ROLE:');
	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
	 $this->withoutMiddleware(\Illuminate\Auth\Middleware\Authenticate::class);
	$role = [
		'name' => 'testRole',
	];
	$response = $this->post(route('Roles.store'),$role);
	$this->log('successful response');
	$response->assertSessionHas('response');
	$this->log('role was added to db');
	$this->assertDatabaseHas('roles',['name' => 'testRole']);

    }
    public function testDeleteRole()
    {
    	$this->log('TEST DELETE ROLE:');
    	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
	 $this->withoutMiddleware(\Illuminate\Auth\Middleware\Authenticate::class);
    	$role = Role::firstOrCreate(['name' => 'testRole', 'guard_name' => 'web']);
    	$response = $this->delete(route('Roles.destroy',['id' => encode($role->id)]));
    	$this->log('successful response');
    	$response->assertSessionHas('response');
    	$this->log('role was deleted from db');
    	$this->assertDatabaseMissing('roles',['id' => $role->id]);

    }
}
