<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $primaryKey = "id";

    public $incrementing = true;

    protected $fillable = ["email", "password", "token"];


    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, "user_id", "id");
    }
}
