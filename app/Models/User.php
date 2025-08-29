<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',
        'name',
    ];

    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }

    /**
     * Find the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function findForPassport($username)
    {
        return $this->where('nik', $username)->first();
    }

    /**
     * Validate the user's credentials.
     *
     * @param  \App\Models\User  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(User $user, array $credentials)
    {
        // Since we are not using a password, we only need to check if the NIK matches.
        // The 'name' field is for display purposes and not part of authentication credentials.
        return $user->nik === $credentials['nik'];
    }
}
