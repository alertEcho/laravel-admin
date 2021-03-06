<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;

class PermissionsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->be(Administrator::first(), 'admin');
    }

    public function testPermissionsIndex()
    {
        $this->visit('admin/auth/permissions')
            ->see('Permissions');
    }

    public function testAddAndDeletePermission()
    {
        $this->visit('admin/auth/permissions/create')
            ->see('Permissions')
            ->submitForm('Submit', ['slug' => 'can-edit', 'name' => 'Can edit'])
            ->seePageIs('admin/auth/permissions')
            ->seeInDatabase('permissions', ['slug' => 'can-edit'])
            ->seeInDatabase('permissions', ['name' => 'Can edit'])
            ->assertEquals(1, Permission::count());

        $this->delete('admin/auth/permissions/1')
            ->assertEquals(0, Permission::count());
    }

    public function testEditPermission()
    {
        $this->visit('admin/auth/permissions/create')
            ->see('Permissions')
            ->submitForm('Submit', ['slug' => 'can-edit', 'name' => 'Can edit'])
            ->seePageIs('admin/auth/permissions')
            ->seeInDatabase('permissions', ['slug' => 'can-edit'])
            ->seeInDatabase('permissions', ['name' => 'Can edit'])
            ->assertEquals(1, Permission::count());

        $this->visit('admin/auth/permissions/1/edit')
            ->see('Permissions')
            ->submitForm('Submit', ['slug' => 'can-delete'])
            ->seePageIs('admin/auth/permissions')
            ->seeInDatabase('permissions', ['slug' => 'can-delete'])
            ->assertEquals(1, Permission::count());
    }
}
