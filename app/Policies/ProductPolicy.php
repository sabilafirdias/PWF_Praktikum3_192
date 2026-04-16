<?php

namespace App\Policies;

use App\Models\ProductModel;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductModel $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function update(User $user, ProductModel $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductModel $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductModel $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductModel $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }
}