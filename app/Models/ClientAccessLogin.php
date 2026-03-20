<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ClientAccessLogin extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'clients_access_login';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'productStore',
        'clientFirstName',
        'clientMiddleName',
        'clientLastName',
        'clientPhoneNumber',
        'clientEmailAddress',
        'clientPassword',
        'isActive',
        'deleteStatus',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'clientPassword',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'isActive' => 'boolean',
        'deleteStatus' => 'integer',
    ];

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->clientPassword;
    }

    /**
     * Scope for active (non-deleted) records.
     */
    public function scopeActive($query)
    {
        return $query->where('deleteStatus', 1);
    }

    /**
     * Scope for enabled accounts.
     */
    public function scopeEnabled($query)
    {
        return $query->where('isActive', 1);
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->clientFirstName;

        if ($this->clientMiddleName) {
            $name .= ' ' . $this->clientMiddleName;
        }

        if ($this->clientLastName) {
            $name .= ' ' . $this->clientLastName;
        }

        return $name;
    }

    /**
     * Get initials for avatar.
     */
    public function getInitialsAttribute(): string
    {
        $first = $this->clientFirstName ? strtoupper(substr($this->clientFirstName, 0, 1)) : '';
        $last = $this->clientLastName ? strtoupper(substr($this->clientLastName, 0, 1)) : '';

        return $first . $last;
    }

    /**
     * Find user by email or phone for login.
     */
    public static function findForLogin(string $login): ?self
    {
        return static::active()
            ->enabled()
            ->where(function ($query) use ($login) {
                $query->where('clientEmailAddress', $login)
                      ->orWhere('clientPhoneNumber', $login);
            })
            ->first();
    }
}
