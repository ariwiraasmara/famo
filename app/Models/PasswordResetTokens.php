<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetTokens extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'password_reset_tokens';
    public $incrementing = false;
    protected $fillable = ["email",
                            "token",
                            "created_at",];

    public $timestamps = false;
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

}
