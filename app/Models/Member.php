<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $casts = [
        'expired_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'user_id',
        'packagedetail_id',
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

    public function packageDetail()
    {
        return $this->belongsTo(PackageDetail::class, 'packagedetail_id', 'id');
    }

    public function downloadHistories()
    {
        return $this->hasMany(DownloadHistory::class, 'user_id', 'id');
    }
}
