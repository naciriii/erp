<?php

namespace Modules\Users\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Role;
use Permission;
use App\User;

class UsersTest extends TestCase
{
	use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testAddUser()
    {
        //dd(env('APP_ENV'),env('DB_CONNECTION'));

    	 $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    	$user = [
    		'name' => 'Testing',
    		'email' => 'test'.uniqid().'@test.test',
    		'password' => 'password',
    		'password_confirmation' => 'password'
    	];

    	$response = $this->post(route('Users.store'),$user);
        $this->log('TEST ADD NEW USER:');
        $this->log('successfull response');
    	$response->assertSessionHas('response');
        $this->log('user added to db');
    	$this->assertDatabaseHas('users',['email' => $user['email']]);

    }
    public function testAddUserWithRole()
    {
        $this->log('TEST ADD NEW USER WITH ROLES:');
    	
    	$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $role = Role::firstOrCreate(['name' => 'Testrole','guard_name' => 'web']);
        $permission = Permission::firstOrCreate([
            'name' => 'perm_0','guard_name' => 'web'
        ]);
        $role->givePermissionTo($permission);

    
    	$user = [
    		'name' => 'Testing',
    		'email' => 'test'.uniqid().'@test.test',
    		'password' => 'password',
    		'password_confirmation' => 'password',
    		'roles' => [$role->id]
    	];
    	
    	$response = $this->post(route('Users.store'),$user);
        $this->log('successful response');
    	$response->assertSessionHas('response');
        $this->log('user added to db');
    	$this->assertDatabaseHas('users',['email' => $user['email']]);
    	$user = User::where('email',$user['email'])->first();
    	$this->assertNotNull($user);
         $this->log('user has the assigned role');
    	$this->assertTrue($user->roles->contains('id',$role->id));
         $this->log('user has the assigned permissions(role/direct)');
        $this->assertTrue($user->hasPermissionTo($permission));





    }
    public function testAddUserWithPermission()
    {
        $this->log('TEST ADD USER WITH PEMRISSION:');
        
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
        $this->log('successful response');
        $response->assertSessionHas('response');
        $this->log('user added in db');
        $this->assertDatabaseHas('users',['email' => $user['email']]);
        $user = User::where('email',$user['email'])->first();
        $this->assertNotNull($user);
        $this->log('user has direct permissions');
        $this->assertTrue($user->hasDirectPermission($permission));


    }
    public function testDeleteUser()
    {
        $this->log('TEST DELETE USER:');
         $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
         $user = User::firstOrCreate([
            'name' => 'TestUser',
            'email' => 'test@test.test',
            'password'=>'123456']
        );
         $this->assertDatabaseHas('users',['id' => $user->id]);
        $response = $this->delete(route('Users.delete',['id' => encode($user->id)]));
        $this->log('successful response');
        $response->assertSessionHas('response');
        $this->log('redirect to index');
        $response->assertRedirect(route('Users.index'));
        $this->log('user doesnt exists on db');
        $this->assertDatabaseMissing('users',['id' => $user->id]);

    }
    public function testUpdateUser()
    {
        $this->log('TEST UPDATE USER:');
         $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
         $user = User::firstOrCreate([
            'name' => 'TestUser',
            'email' => 'test@test.test',
            'password'=>'123456']
        );
         $updated_user = [
            'name' => 'TestUser30',
            'email' => 'test@test.test'
         ];
        $response = $this->patch(route('Users.update',['id' => encode($user->id)]),$updated_user);
        $this->log('successful response');
        $response->assertSessionHas('response');
        $updated  = User::find($user->id);
         $this->log('user was updated');
        $this->assertEquals($updated->name,$updated_user['name']);

    }
    public function testShowUser()
    {
        $this->withMiddleware();
         $user = User::firstOrCreate([
            'name' => 'TestUser',
            'email' => 'test@test.test',
            'password'=>'123456']
        );
         $response = $this->actingAs($user)->get(route('Users.show',['id' => encode($user->id)]));
        $this->log('users show view returned');
         $response->assertViewIs('users::show');
        $this->log('users show view has user instance');
         $response->assertViewHas('user');

    }

}
