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
        'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'id', 'package_id');
    }
}
