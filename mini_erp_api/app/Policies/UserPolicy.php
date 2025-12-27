<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin tüm kullanıcıları görebilir
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    /**
     * Admin herkesi görebilir
     * User sadece kendini görebilir
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->id === $user->id;
    }

    /**
     * Sadece admin kullanıcı oluşturabilir
     */
    public function create(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    /**
     * Admin herkesi güncelleyebilir
     * User sadece kendini güncelleyebilir
     */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->id === $user->id;
    }

    /**
     * Kullanıcı silme sadece admin
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->isAdmin();
    }
}
