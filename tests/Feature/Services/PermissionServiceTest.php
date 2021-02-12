<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PermissionStoreRequest;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PermissionService $permissionService;

    private User $user1;
    private Permission $permission1;
    private Permission $permission2;
    private Permission $permission3;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->permissionService = $this->app->make('App\Services\PermissionService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);
        $this->user1->givePermissionTo('posts.edit');
        $this->user1->givePermissionTo('insights.create');

        //$this->permission1 = Permission::factory()->create()->setStatus('published');
        //$this->permission2 = Permission::factory()->create()->setStatus('published');
        //$this->permission3 = Permission::factory()->create()->setStatus('published');
    }

    /** @test */
    public function itShouldGetUserPermissions()
    {
        $permissions = $this->permissionService->getUserPermissions($this->user1->id);
        $this->assertCount(2, $permissions);
    }


}