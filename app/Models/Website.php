<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'image',
        'status',
        'name',
        'sample_link',
        'website_link',
        'is_download_by_retail',
    ];
}
