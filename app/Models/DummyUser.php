<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

class DummyUser implements JWTSubject
{
    public $id;
    public $name;
    public $email;

    public function __construct($attributes)
    {
        // Pastikan ada tanda '=' dan '$' [cite: 50]
        $this->id = $attributes['id'] ?? null;
        $this->name = $attributes['name'] ?? null;
        $this->email = $attributes['email'] ?? null;
    }

    public function getJWTIdentifier()
    {
        return $this->email;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}