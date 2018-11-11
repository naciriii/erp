<?php

namespace Modules\Users\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Role;
use Permission;
use App\User;

class UsersTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function testAddUser()
    {
    	 $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    	$user = [
    		'name' => 'Testing',
    		'email' => 'test'.uniqid().'@test.test',
    		'password' => 'password',
    		'password_confirmation' => 'password'
    	];

    	$response = $this->post(route('Users.store'),$user);
    	$response->assertSessionHas('response');
    	$this->assertDatabaseHas('users',['email' => $user['email']]);

    }
    public function testAddUserWithRole()
    {
    	
    	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $role = Role::firstOrCreate(['name' => 'Testrole','guard_name' => 'web']);
    
    	$user = [
    		'name' => 'Testing',
    		'email' => 'test'.uniqid().'@test.test',
    		'password' => 'password',
    		'password_confirmation' => 'password',
    		'roles' => [$role->id]
    	];
    	
    	$response = $this->post(route('Users.store'),$user);
    	$response->assertSessionHas('response');
    	$this->assertDatabaseHas('users',['email' => $user['email']]);
    	$user = User::where('email',$user['email'])->first();
    	$this->assertNotNull($user);
    
    	$this->assertTrue($user->roles->contains('id',$role->id));




    }
    public function testAddUserWithPermission()
    {
        
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $permission = Permission::firstOrCreate(['name' => 'TestPermission','guard_name' => 'web']);
    
        $user = [
            'name' => 'Testing',
            'email' => 'test'.uniqid().'@test.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'permissions' => [$permission->id]
        ];
        
        $response = $this->post(route('Users.store'),$user);
        $response->assertSessionHas('response');
        $this->assertDatabaseHas('users',['email' => $user['email']]);
        $user = User::where('email',$user['email'])->first();
        $this->assertNotNull($user);
    
        $this->assertTrue($user->permissions->contains('id',$permission->id));




    }
}
