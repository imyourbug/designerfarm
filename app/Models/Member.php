<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'expire',
        'expired_at',
        'number_file',
        'downloaded_number_file',
        'website_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function downloadHistories()
    {
        return $this->hasMany(DownloadHistory::class, 'user_id', 'id');
    }
}
