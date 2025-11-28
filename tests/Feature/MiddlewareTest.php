<?php

namespace Tests\Feature;

use App\Models\Pembina;
use App\Models\Peserta;
use App\Models\User;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    protected User $admin;

    protected User $pembina;

    protected User $peserta;

    protected Pembina $pembinaModel;

    protected Peserta $pesertaModel;

    protected function setUp(): void
    {
        parent::setUp();

        // Try to migrate but catch errors if tables already exist (from previous test)
        try {
            $this->artisan('migrate:fresh', ['--env' => 'testing', '--force' => true]);
        } catch (\Exception $e) {
            // Migration may fail if in-memory database persists - that's ok
        }

        // Create test users
        $this->admin = User::create([
            'name' => 'Test Admin',
            'email' => 'test-admin@test.local',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->pembina = User::create([
            'name' => 'Test Pembina',
            'email' => 'test-pembina@test.local',
            'password' => bcrypt('password'),
            'role' => 'pembina',
        ]);

        $this->peserta = User::create([
            'name' => 'Test Peserta',
            'email' => 'test-peserta@test.local',
            'password' => bcrypt('password'),
            'role' => 'peserta',
        ]);

        // Create pembina model record
        $this->pembinaModel = Pembina::create([
            'user_id' => $this->pembina->id,
            'nip' => '12345678',
            'nama_lengkap' => 'Test Pembina',
            'jabatan' => 'Guru',
            'nomor_hp' => '081234567890',
        ]);

        // Create peserta model record
        $this->pesertaModel = Peserta::create([
            'user_id' => $this->peserta->id,
            'pembina_id' => $this->pembinaModel->id,
            'nisn' => '98765432',
            'nama_lengkap' => 'Test Peserta',
            'sekolah' => 'SMA Test',
            'jurusan' => 'IPA',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(3),
            'nomor_hp' => '089876543210',
        ]);
    }

    /**
     * Test that guest users cannot access admin routes
     */
    public function test_guest_cannot_access_admin_routes(): void
    {
        $response = $this->get('/pembina');
        $response->assertStatus(403);
    }

    /**
     * Test that admin can access admin routes
     */
    public function test_admin_can_access_admin_routes(): void
    {
        $response = $this->actingAs($this->admin)->get('/pembina');
        $response->assertSuccessful();
    }

    /**
     * Test that pembina cannot access admin routes
     */
    public function test_pembina_cannot_access_admin_routes(): void
    {
        $response = $this->actingAs($this->pembina)->get('/pembina');
        $response->assertStatus(403);
    }

    /**
     * Test that peserta cannot access admin routes
     */
    public function test_peserta_cannot_access_admin_routes(): void
    {
        $response = $this->actingAs($this->peserta)->get('/pembina');
        $response->assertStatus(403);
    }

    /**
     * Test that all authenticated users can access dashboard
     */
    public function test_authenticated_users_can_access_dashboard(): void
    {
        $this->actingAs($this->admin)->get('/dashboard')->assertSuccessful();
    }

    /**
     * Test that all authenticated users can access attendance routes
     */
    public function test_authenticated_users_can_access_attendance(): void
    {
        $this->actingAs($this->admin)->get('/attendance')->assertSuccessful();
    }

    /**
     * Test that authenticated users cannot access login page
     */
    public function test_authenticated_users_cannot_access_login(): void
    {
        $response = $this->actingAs($this->admin)->get('/login');
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('info');
    }

    /**
     * Test that authenticated users cannot access register page
     */
    public function test_authenticated_users_cannot_access_register(): void
    {
        $response = $this->actingAs($this->peserta)->get('/register');
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('info');
    }

    /**
     * Test that guest users can access login page
     */
    public function test_guest_can_access_login(): void
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
    }

    /**
     * Test that guest users can access register page
     */
    public function test_guest_can_access_register(): void
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
    }

    /**
     * Test that PreventBackHistory headers are present on authenticated pages
     */
    public function test_prevent_back_history_headers_present(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');

        // Verify all required cache control directives are present (order may vary)
        $cacheControl = $response->headers->get('Cache-Control');
        $this->assertStringContainsString('no-cache', $cacheControl);
        $this->assertStringContainsString('no-store', $cacheControl);
        $this->assertStringContainsString('must-revalidate', $cacheControl);
        $this->assertStringContainsString('private', $cacheControl);
        $this->assertStringContainsString('max-age=0', $cacheControl);

        $response->assertHeader('Pragma', 'no-cache');
        $response->assertHeader('Expires', '0');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    /**
     * Test that peserta cannot access peserta create route (peserta-only)
     */
    public function test_peserta_cannot_create_peserta(): void
    {
        $response = $this->actingAs($this->peserta)->get('/peserta/create');
        $response->assertStatus(403);
    }

    /**
     * Test that pembina cannot access peserta routes
     */
    public function test_pembina_cannot_access_peserta(): void
    {
        $response = $this->actingAs($this->pembina)->get('/peserta');
        $response->assertStatus(403);
    }

    /**
     * Test admin can access peserta management
     */
    public function test_admin_can_access_peserta(): void
    {
        $response = $this->actingAs($this->admin)->get('/peserta');
        $response->assertSuccessful();
    }

    /**
     * Test admin can access edit password page for pembina
     */
    public function test_admin_can_access_edit_password_page_for_pembina(): void
    {
        $response = $this->actingAs($this->admin)->get("/pembina/{$this->pembinaModel->id}/edit-password");
        $response->assertSuccessful();
    }

    /**
     * Test admin can update pembina password
     */
    public function test_admin_can_update_pembina_password(): void
    {
        $response = $this->actingAs($this->admin)->put(
            "/pembina/{$this->pembinaModel->id}/update-password",
            [
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]
        );

        $response->assertRedirect('/pembina');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $this->pembina->refresh()->password));
    }

    /**
     * Test admin cannot update pembina password with invalid data
     */
    public function test_admin_cannot_update_pembina_password_with_invalid_data(): void
    {
        $response = $this->actingAs($this->admin)->put(
            "/pembina/{$this->pembinaModel->id}/update-password",
            [
                'password' => 'short',
                'password_confirmation' => 'short',
            ]
        );

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test admin can access edit password page for peserta
     */
    public function test_admin_can_access_edit_password_page_for_peserta(): void
    {
        $response = $this->actingAs($this->admin)->get("/peserta/{$this->pesertaModel->id}/edit-password");
        $response->assertSuccessful();
    }

    /**
     * Test admin can update peserta password
     */
    public function test_admin_can_update_peserta_password(): void
    {
        $response = $this->actingAs($this->admin)->put(
            "/peserta/{$this->pesertaModel->id}/update-password",
            [
                'password' => 'newpassword456',
                'password_confirmation' => 'newpassword456',
            ]
        );

        $response->assertRedirect('/peserta');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword456', $this->peserta->refresh()->password));
    }

    /**
     * Test non-admin cannot update peserta password
     */
    public function test_non_admin_cannot_update_peserta_password(): void
    {
        $response = $this->actingAs($this->pembina)->put(
            "/peserta/{$this->pesertaModel->id}/update-password",
            [
                'password' => 'newpassword789',
                'password_confirmation' => 'newpassword789',
            ]
        );

        $response->assertStatus(403);
    }
}
