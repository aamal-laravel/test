<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Determine whether the user can update the service.
     */
    public function update(User $user, Service $service): bool
    {
        // Admins can update any service
        if ($user->is_admin) {
            return true;
        }

        // Provider owner can update
        return $user->provider && $service->provider_id === $user->provider->id;
    }

    /**
     * Determine whether the user can delete the service.
     */
    public function delete(User $user, Service $service): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->provider && $service->provider_id === $user->provider->id;
    }
}
