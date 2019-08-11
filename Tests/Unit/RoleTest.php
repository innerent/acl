<?php

namespace Innerent\Acl\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Innerent\Acl\Entities\Role;
use Innerent\Acl\Repositories\RoleRepository;
use Innerent\Acl\Services\RoleService;
use Innerent\People\Entities\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    private $authUser;

    function setUp(): void
    {
        parent::setUp();

        $this->authUser = factory(User::class)->create();
    }

    public function testCreateRole()
    {
        $data = factory(Role::class)->make()->toArray();

        $this->actingAs($this->authUser, 'api')->json('post', env('INNERENT_API_PREFIX', 'v1').'/acl/roles', $data)
            ->assertStatus(201);
    }

    public function testListRoles()
    {
        $this->actingAs($this->authUser, 'api')->json('get', env('INNERENT_API_PREFIX', 'v1').'/acl/roles')
            ->assertStatus(200);
    }

    public function testShowRole()
    {
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $this->actingAs($this->authUser, 'api')->json('get', env('INNERENT_API_PREFIX', 'v1').'/acl/roles/' . $role->id)
            ->assertStatus(200);
    }

    public function testUpdateRole()
    {
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $newData = factory(Role::class)->make()->toArray();

        $roleUpdated = $roleService->make($newData)->toArray();
        $roleUpdated['id'] = $role->id;

        $this->actingAs($this->authUser, 'api')->json('put', env('INNERENT_API_PREFIX', 'v1').'/acl/roles/' . $role->id, $newData)
            ->assertJsonFragment($roleUpdated)
            ->assertStatus(200);
    }

    public function testDeleteRole()
    {
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $this->actingAs($this->authUser, 'api')->json('delete', env('INNERENT_API_PREFIX', 'v1').'/acl/roles/' . $role->id)->assertStatus(204);
    }
}
