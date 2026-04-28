<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_can_login_with_remember_enabled(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@systex.local',
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_can_download_purchase_pdf(): void
    {
        $admin = User::query()->where('login', 'admin@systex.local')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('purchases.pdf'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }
}
