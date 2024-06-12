<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'website_id',
        'avatar',
        'description',
        // 'price',
        // 'number_file',
        // 'expire',
        // 'price_sale',
        // 'file_per_day',
        // 'number_download',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'user_id', 'id');
    }
}
