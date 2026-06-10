<?php

namespace Tests\Feature\GraphQL;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_and_returns_token(): void
    {
        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    register(name: "Kanon", email: "kanon@test.com", password: "secret") {
                        token
                        user {
                            id
                            name
                            email
                        }
                    }
                }
            ',
        ]);

        $response->assertJsonPath('data.register.user.name', 'Kanon');
        $response->assertJsonPath('data.register.user.email', 'kanon@test.com');
        $this->assertNotEmpty($response->json('data.register.token'));
        $this->assertDatabaseHas('users', ['email' => 'kanon@test.com']);
    }

    public function test_register_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'kanon@test.com']);

        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    register(name: "Kanon", email: "kanon@test.com", password: "secret") {
                        token
                    }
                }
            ',
        ]);

        $response->assertJsonPath('errors.0.message', 'Internal server error');
    }

    public function test_login_returns_token(): void
    {
        User::factory()->create([
            'email'    => 'kanon@test.com',
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);

        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    login(email: "kanon@test.com", password: "secret") {
                        token
                        user {
                            id
                            email
                        }
                    }
                }
            ',
        ]);

        $this->assertNotEmpty($response->json('data.login.token'));
        $response->assertJsonPath('data.login.user.email', 'kanon@test.com');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'kanon@test.com',
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);

        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    login(email: "kanon@test.com", password: "wrong") {
                        token
                    }
                }
            ',
        ]);

        $response->assertJsonPath('errors.0.message', 'Internal server error');
    }
}