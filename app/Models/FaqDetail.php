<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqDetail extends Model
{
    use HasFactory;

    protected $table = 'faq_details';

    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'show_product_page',
        'faq_image_1',
        'faq_image_2',
        'created_by',
    ];
}
