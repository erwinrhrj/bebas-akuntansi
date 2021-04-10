<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pengguna extends Authenticatable implements JWTSubject , AuthenticatableContract, AuthorizableContract
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';

    protected $fillable = [
        'pengguna_name',
        'pengguna_username',
        'pengguna_password',
        'pengguna_status',
        'pengguna_posisi',
        'created_at', 
        'updated_at', 
    ];

    protected $hidden = [
        'pengguna_password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pengguna_password;
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

}
