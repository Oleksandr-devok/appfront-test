<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{

    public function test_login_page_loads_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_fails_with_empty_fields(): void
    {
        $data = [
            'email' => '',
            'password' => '',
        ];
        $response = $this->post(route('login.submit'), $data);
        $response->assertInvalid();
        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertStatus(302);
    }

    public function test_that_login_fails_with_invalid_email(): void
    {
        $response = $this->post(route('login.submit'), [
            'email' => 'not-a-valid-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(302);
    }

    public function test_that_login_fails_with_wrong_credentials(): void
    {

        $user = User::create([
            'name' => 'Test',
            'email' => 'john@example.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $response->assertSessionHas('error', 'Invalid login credentials');
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'jane@test.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'jane@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products'));
    }

    public function test_user_can_logout()
    {
        $response = $this->actingAs($this->user)->post(route('logout'));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_login_form_is_safe_from_sql_injection()
    {

        $sqlInjectionEmail = "' OR '1'='1";
        $sqlInjectionPassword = "' OR '1'='1";

        $response = $this->post(route('login.submit'), [
            'email' => $sqlInjectionEmail,
            'password' => $sqlInjectionPassword,
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(status: 302);
        $response->assertRedirect(route('login'));
    }
}
