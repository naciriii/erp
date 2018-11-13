<?php

namespace Modules\Authorization\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Permission;

class PermissionsTest extends TestCase
{
   
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
  
    public function testAddPermission()
    {
    	$this->log('TEST ADD PERMISSION:');
	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
	 $this->withoutMiddleware(\Illuminate\Auth\Middleware\Authenticate::class);
	$permission = [
		'name' => 'testPermission',
	];
	$response = $this->post(route('Permissions.store'),$permission);
	$this->log('successful response');
	$response->assertSessionHas('response');
	$this->log('permission was added to db');
	$this->assertDatabaseHas('permissions',['name' => 'testPermission']);

    }
    public function testDeletePermission()
    {
    	$this->log('TEST DELETE PERMISSION:');
    	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
	 $this->withoutMiddleware(\Illuminate\Auth\Middleware\Authenticate::class);
    	$permission = Permission::firstOrCreate(['name' => 'testPermission', 'guard_name' => 'web']);
    	$response = $this->delete(route('Permissions.destroy',['id' => encode($permission->id)]));
    	$this->log('successful response');
    	$response->assertSessionHas('response');
    	$this->log('permission was deleted from db');
    	$this->assertDatabaseMissing('permissions',['id' => $permission->id]);

    }
}
