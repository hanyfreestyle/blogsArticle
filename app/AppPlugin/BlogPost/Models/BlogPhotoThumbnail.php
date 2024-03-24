<?php

namespace App\AppPlugin\BlogPost\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPhotoThumbnail extends Model {
    protected $table = "blog_photo_thumbnail";
    public $timestamps = false;

//    public function productName(): BelongsTo {
//        return $this->belongsTo(Product::class, 'product_id', 'id');
//    }
}
