<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessTokens extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'personal_access_tokens';
    public $incrementing = false;
    protected $fillable = ["id",
                            "tokenable",
                            "name",
                            "token",
                            "abilities",
                            "last_used_at",
                            "expires_at"];

    public $timestamps = true;
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'updated_date';
}
