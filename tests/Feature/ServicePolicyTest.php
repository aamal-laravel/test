<?php

use App\Models\User;
use App\Models\Provider;
use App\Models\Service;

beforeEach(function () {
    $this->providerUser = User::factory()->create();
    $this->provider = Provider::create([
        'name' => 'Test Provider',
        'description' => 'desc',
        'user_id' => $this->providerUser->id,
    ]);

    $this->service = Service::create([
        'name' => 'Test Service',
        'identifier' => 'svc-'.uniqid(),
        'provider_id' => $this->provider->id,
    ]);

    $this->otherUser = User::factory()->create();
});

it('allows provider owner to update service', function () {
    $token = $this->providerUser->createToken('test')->plainTextToken;

    $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->putJson('/api/provider/services/'.$this->service->id, [
            'name' => 'Updated Name'
        ]);

    $response->assertStatus(200);
});

it('forbids other user from updating service', function () {
    $token = $this->otherUser->createToken('test')->plainTextToken;

    $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->putJson('/api/provider/services/'.$this->service->id, [
            'name' => 'Malicious Update'
        ]);

    $response->assertStatus(403);
});
