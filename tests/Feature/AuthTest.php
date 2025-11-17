<?php

use Illuminate\Support\Str;
use App\Models\User;

it('can register and receive token', function () {
    $email = 'test+' . Str::random(6) . '@example.com';

    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => $email,
        'password' => 'password123',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure(['user' => ['id','email'], 'token']);

    // user exists
    expect(User::where('email', $email)->exists())->toBeTrue();
});

it('can login with correct credentials', function () {
    $password = 'secret123';
    $user = User::factory()->create(['password' => bcrypt($password)]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['user' => ['id','email'], 'token']);
});
