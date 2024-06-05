<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'number_file',
        'expire',
        'amount_time',
        'type',
    ];

    public function userPakages()
    {
        return $this->hasMany(UserPackage::class, 'user_id', 'id');
    }
}
