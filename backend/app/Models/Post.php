<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts = ['hero' => 'boolean'];

    protected $dates = ['released_at', 'deleted_at'];

    protected $fillable = ['title', 'slug', 'headline', 'body', 'views', 'user_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'post_images');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'post_comments');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn ($query, $search) => $query->where('title', 'like', '%' . $search . '%')->orWhere('body', 'like', '%' . $search . '%'));

        $query->when($filters['author'] ?? false, fn ($query, $author) => $query->whereHas('user', fn ($query) => $query->where('name', $author)));

        $query->when($filters['category'] ?? false, fn ($query, $category) => $query->whereHas('category', fn ($query) => $query->where('slug', $category)));

        $query->when($filters['tags'] ?? false, fn ($query, $tags) => $query->whereHas('tags', fn ($query) => $query->where('name', $tags)));
    }
}
