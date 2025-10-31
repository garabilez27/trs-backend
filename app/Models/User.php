<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Customized table name
    protected $table = 'tbl_users';

    // Primary key
    protected $primaryKey = 'usr_id';

    // Disable default timestamps
    public $timestamps = true;

    // Set custom names for timestamp columns
    const CREATED_AT = 'usr_created_at';
    const UPDATED_AT = 'usr_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'usr_name',
        'usr_email',
        'usr_password',
        'usr_created_at',
        'usr_updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierNameName()
    {
        return 'usr_email';
    }

    public function getAuthPassword()
    {
        return $this->usr_password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
