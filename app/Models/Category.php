<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'rank', // ✅ เพิ่ม 'rank' ตรงนี้
    ];

    // (โค้ดอื่นๆ ใน Model ของคุณ)
}