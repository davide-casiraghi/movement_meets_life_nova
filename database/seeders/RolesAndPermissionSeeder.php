<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CREATE PERMISSIONS


        // Members notes
        Permission::create(['name' => 'member_notes.create']);


        // Admins
        Permission::create(['name' => 'admins.view']);
        Permission::create(['name' => 'admins.create']);
        Permission::create(['name' => 'admins.edit']);
        Permission::create(['name' => 'admins.delete']);

        // Teams
        Permission::create(['name' => 'teams.view']);
        Permission::create(['name' => 'teams.edit']);
        Permission::create(['name' => 'teams.create']);


        // Permissions
        Permission::create(['name' => 'permissions.edit']);

        // Passwords
        Permission::create(['name' => 'user_passwords.edit']);

        // Posts
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.view']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);
        Permission::create(['name' => 'posts.approve']);

        // Teachers
        Permission::create(['name' => 'teachers.create']);
        Permission::create(['name' => 'teachers.view']);
        Permission::create(['name' => 'teachers.edit']);
        Permission::create(['name' => 'teachers.delete']);
        Permission::create(['name' => 'teachers.approve']);

        // Organizers
        Permission::create(['name' => 'organizers.create']);
        Permission::create(['name' => 'organizers.view']);
        Permission::create(['name' => 'organizers.edit']);
        Permission::create(['name' => 'organizers.delete']);
        Permission::create(['name' => 'organizers.approve']);

        // Venues
        Permission::create(['name' => 'venues.create']);
        Permission::create(['name' => 'venues.view']);
        Permission::create(['name' => 'venues.edit']);
        Permission::create(['name' => 'venues.delete']);
        Permission::create(['name' => 'venues.approve']);

        // Events
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.view']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);
        Permission::create(['name' => 'events.approve']);





        // CREATE ROLES

        // Create Super Admin role and attach all permissions
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        // Create Admin role and attach the related permissions
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('teams.edit');

        // Team Roles
        $role = Role::create(['name' => 'Editor']);
        $role->givePermissionTo([
            'posts.view',
            'posts.create',
            'posts.view',
            'posts.approve'
        ]);

        $role = Role::create(['name' => 'Member']);
        $role->givePermissionTo([
            'teachers.create',
            'teachers.edit',
            'organizers.create',
            'teachers.edit',
            'venues.create',
            'venues.edit',
            'events.create',
            'events.edit',
        ]);


    }
}
