<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    public $table = "post_images";

    public $timestamps = false;

    protected $fillable = ['post_id', 'image_id'];
}
