<?php

namespace Tests\Feature\Controllers;

use App\Models\Insight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class InsightControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Insight $insight1;

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

        $this->insight1 = Insight::factory()->create();
    }

    /** @test */
    public function itShouldDisplayTheInsightsIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get('insights');

        $response->assertStatus(200);
        $response->assertViewIs('insights.index');
    }

    /** @test */
    public function itShouldDisplayTheInsightsIndexViewToAdminWithInsightIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('insights.view');

        $response = $this->get('insights');

        $response->assertStatus(200);
        $response->assertViewIs('insights.index');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingTheIndexViewWithoutInsightIndexPermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('insights');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheInsightsIndexPageToLoginPage()
    {
        $response = $this->get('insights');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingTheInsightCreatePageWithoutInsightCreatePermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/insights/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheInsightsCreateViewToAdminWithInsightCreatePermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('insights.create');

        $response = $this->get("/insights/create");

        $response->assertViewIs('insights.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheInsightsCreatePageToLoginPage()
    {
        $response = $this->get('/insights/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheInsightsCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/insights/create");

        $response->assertStatus(200);
        $response->assertViewIs('insights.create');
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidInsight()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title',
            'body' => 'test body',
        ];
        $response = $this->post('/insights', $parameters);

        $response->assertRedirect('/insights');
        $this->assertDatabaseHas('insights', [
            'slug' => 'test-title',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidInsight()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/insights', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingTheInsightEditPageWithoutInsightEditPermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/insights/{$this->insight1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheInsightEditViewToAdminWithInsightEditPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('insights.edit');

        $response = $this->get("/insights/{$this->insight1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('insights.edit');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheInsightsEditPageToLoginPage()
    {
        $response = $this->get("/insights/{$this->insight1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheInsightsEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/insights/{$this->insight1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('insights.edit');
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidInsight()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title updated',
            'body' => 'test body',
        ];
        $response = $this->put("/insights/{$this->insight1->id}", $parameters);

        $this->assertDatabaseHas('insights', [
            'slug' => 'test-title-updated',
        ]);
        $response->assertRedirect('/insights');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteInsights()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/insights/{$this->insight1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/insights');
        $this->assertDeleted($this->insight1);
    }

    /** @test */
    public function itShouldAllowTheAdminToDeleteAnInsightWithInsightDeletePermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('insights.delete');

        $response = $this->delete("/insights/{$this->insight1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/insights');
        $this->assertNull($this->insight1->fresh());
    }

    /** @test */
    public function itShouldNotAllowTheAdminToDeleteAnInsightWithoutInsightDeletePermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/insights/{$this->insight1->id}");
        $response->assertRedirect('/insights');
        $response->assertStatus(500);
    }

    /** ------------------------------------------------------------------------------------- */
    /** @test */
    public function itShouldDisplayTheInsightShowViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get("/insights/{$this->insight1->id}");

        $response->assertStatus(200);
        $response->assertViewIs('insights.show');
    }

    /** @test */
    public function itShouldDisplayTheInsightShowViewToAdminWithInsightViewPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('insights.view');

        $response = $this->get("/insights/{$this->insight1->id}");

        $response->assertStatus(200);
        $response->assertViewIs('insights.show');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingTheInsightShowViewWithoutInsightViewPermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/insights/{$this->insight1->id}");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheInsightsShowPageToLoginPage()
    {
        $response = $this->get("/insights/{$this->insight1->id}");
        $response->assertRedirect('/login');
    }
}
