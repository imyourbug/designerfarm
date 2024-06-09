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
        'type',
        'website_id',
        'avatar',
        'price_sale',
        'description',
        // 'file_per_day',
        // 'number_download',
    ];

    public function userPakages()
    {
        return $this->hasMany(UserPackage::class, 'user_id', 'id');
    }
}
