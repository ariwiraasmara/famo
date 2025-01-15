<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyMember extends Model {
    use HasFactory;

    protected $guarded = [];
    protected $table = 'my_member';
    public $incrementing = false;
    protected $fillable = ['mid',
                            'id_user',
                            'id_member'];

    public $timestamps = false;
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

    public static $instance = null;
    public function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function user() {
        // NamaModel::class, 'foreign_key', 'local_key'
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
