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

    public function testCreateRole()
    {
        $user = factory(User::class)->create();
        $data = factory(Role::class)->make()->toArray();

        $this->actingAs($user, 'api')->json('post', 'v1/acl/roles', $data)
            ->assertStatus(201);
    }

    public function testListRoles()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api')->json('get', 'v1/acl/roles')
            ->assertStatus(200);
    }

    public function testShowRole()
    {
        $user = factory(User::class)->create();
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $this->actingAs($user, 'api')->json('get', 'v1/acl/roles/' . $role->id)
            ->assertStatus(200);
    }

    public function testUpdateRole()
    {
        $user = factory(User::class)->create();
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $newData = factory(Role::class)->make()->toArray();

        $roleUpdated = $roleService->make($newData)->toArray();
        $roleUpdated['id'] = $role->id;

        $this->actingAs($user, 'api')->json('put', 'v1/acl/roles/' . $role->id, $newData)
            ->assertJsonFragment($roleUpdated)
            ->assertStatus(200);
    }

    public function testDeleteRole()
    {
        $user = factory(User::class)->create();
        $roleService = new RoleService(new RoleRepository(new Role()));
        $role = $roleService->make(factory(Role::class)->make()->toArray());

        $this->actingAs($user, 'api')->json('delete', 'v1/acl/roles/' . $role->id)->assertStatus(204);
    }
}
