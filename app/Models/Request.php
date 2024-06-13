<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'code',
        'user_id',
        'packagedetail_id',
        'total',
        'expire',
        'website_id',
        'status',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function packageDetail()
    {
        return $this->belongsTo(PackageDetail::class, 'packagedetail_id', 'id');
    }
}
