<?php

namespace Tests\Feature\Auth;

use App\Models\InvitationCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        // Create an admin user to generate invitation code
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create a valid invitation code
        $invitationCode = InvitationCode::create([
            'code' => 'TEST123',
            'email' => null, // Universal code
            'role' => 'employé',
            'created_by' => $admin->id,
            'expires_at' => now()->addDays(30),
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'invitation_code' => 'TEST123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
        
        // Verify user was created with correct role
        $user = User::where('email', 'test@example.com')->first();
        $this->assertEquals('employé', $user->role);
        
        // Verify invitation code was marked as used
        $this->assertTrue($invitationCode->fresh()->used);
    }
}
