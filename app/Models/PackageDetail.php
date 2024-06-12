<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'price_sale',
        'expire',
        'number_file',
        'package_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
